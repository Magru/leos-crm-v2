<?php

namespace App\Http\Controllers;

use App\Mail\DealCreated;
use App\Models\Client;
use App\Models\Deal;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Gmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;


class DealController extends Controller{

    private $fetch_mails = [
        'office@leos.co.il',
        'order@leos.co.il'
    ];

    public  $monday_deal_board = '2219425041';

    public function index(){
        $deals = Deal::all();
        return view('deal.index', [
            'deals' => $deals
        ]);
    }

    public function newOrder() :View{

        $users = User::all();
        $products = Product::all();


        return view('deal.new',[
            'users' => $users,
            'products' => $products
        ]);
    }



    public function show($id){
        $deal = Deal::where('id', $id)->first();

        return view('deal.show', [
            'deal' => $deal
        ]);

    }

    public function edit($id){
        $deal = Deal::where('id', $id)->first();
        $users = User::all();
        $products = Product::all();
        $pivot_products = $deal->products()->get();
        $deal_products = [];
        $files = $deal->getMedia('deal-document');
        $filesArray = [];
        foreach ($files->toArray() as $_f){
            $filesArray[] = [
                'name' => $_f['name'],
                'size' => $_f['size'],
                'path' => $_f['original_url']
            ];
        }

        foreach ($pivot_products as $d){
            $deal_products[$d->pivot->product_id] = [
                'qty' => $d->pivot->qty,
                'price' => $d->pivot->price_per_single,
                'attr' => json_decode($d->pivot->attributes, true),
            ];
        }

        return view('deal.edit', [
            'deal' => $deal,
            'users' => $users,
            'products' => $products,
            'deal_products' => $deal_products,
            'files' => $files->toArray(),
            'filesArray' => $filesArray
        ]);
    }

    public function storeDealMedia(Request $request){
        $path = storage_path('tmp/deals');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function store(Request $request){


        $request->validate([
            'client' => 'required',
            'client_review' => 'required',
            'client_seniority' => 'required',
            'price_request_num' => 'required',
            'user_id' => 'required',
        ]);


        $id = $request->input('deal_id');

        $client = $request->input('client');
        $review = $request->input('client_review');
        $branch_review = $request->input('branch_review');
        $client_seniority = $request->input('client_seniority');
        $employed_numbers = $request->input('employed_numbers');
        $price_request_num = $request->input('price_request_num');
        $user_id = $request->input('user_id');
        $note = $request->input('order-notes');
        $tax = $request->input('tax');
        $total = $request->input('total');
        $payment_type = $request->input('payment_type');
        $status = $request->input('status');
        $products = $request->input('products');


        $deal = Deal::updateOrCreate(['id' => $id],[
            'client_review' => $review,
            'branch_review' => $branch_review,
            'client_seniority' => $client_seniority,
            'employed_numbers' => $employed_numbers
        ]);
        $deal->bid_number = $price_request_num;
        $deal->user_id = $user_id;
        $deal->note = $note;
        $deal->date = now();
        $deal->status = $status ?: Deal::PENDING;
        $deal->tax_total = $tax;
        $deal->total_price = $total;
        $deal->payment_type = $payment_type;
        $deal->save();

        foreach ($request->input('document', []) as $file) {
            $deal->addMedia(storage_path('tmp/deals/' . $file))->toMediaCollection('deal-document');
        }
        $clientObject = Client::where('id', $client)->first();
        $deal->client()->associate($clientObject);
        $deal->user()->associate(User::where('id', $user_id)->first());

        if($products){
            $deal->products()->detach();
            foreach ($products as $_p){
                $deal->products()->attach($_p, [
                    'attributes' => $request->input('prod-'. $_p .'-attr-data'),
                    'qty' => $request->input('qty-for-'. $_p),
                    'price_per_single' => $request->input('price-'. $_p),
                ]);
            }
        }

        $deal->save();


        if($status == Deal::PENDING){
            foreach (Deal::MAIL_LIST as $recipient){
                Mail::to($recipient)->send(new DealCreated($deal, Deal::PENDING));
            }
        }

        if($status == Deal::APPROVED){
            $monday = new Monday();
            $monday_res = $monday->addItemsOnBoard($this->monday_deal_board, 'topics',  $clientObject->name, $deal->id);
            if($monday_res){
                $deal->monday_pulse = $monday_res['create_item']['id'];
                $pivot_products = $deal->products()->get();
                if($pivot_products){
                    foreach ($pivot_products as $pp){
                        $monday->addSubItemToItem($this->monday_deal_board,
                            'topics',
                            $monday_res['create_item']['id'],
                            Product::find($pp->pivot->product_id)->name );
                    }
                }
            }


            $monday->updateDealItemPulse($deal, Deal::APPROVED, $monday_res['create_item']['id']);



            //test
            Mail::to('max.folko@gmail.com')->send(new DealCreated($deal, Deal::APPROVED));
        }


        $deal->save();

        return redirect()->route('deal.index');

    }

    public function updateDealTimeline(Client $client){

        foreach ($this->fetch_mails as $_mail){
            $this->fetchClientDeal($client->name, $client->id, $_mail);
        }


        return redirect()->route('timeline.show', [$client->id]);

    }

    public function fetchClientDeal($client_name, $client_id, $account_mail)
    {


        $client = new Google_Client();
        $user_mail = $account_mail;


        if ($credentials_file = $this->checkServiceAccountCredentialsFile()) {
            // set the location manually
            $client->setAuthConfig($credentials_file);
        } elseif (getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
            // use the application default credentials
            $client->useApplicationDefaultCredentials();
        } else {
            Log::alert('Missing Service Account Details');
            return;
        }

        $client->setApplicationName("Client_Fetch_Deals");
        $client->setScopes([
            'https://mail.google.com',
            'https://www.googleapis.com/auth/gmail.readonly',
        ]);
        $client->setConfig('subject', $user_mail);

        $gmail = new Google_Service_Gmail($client);


        $list = $gmail->users_messages->listUsersMessages($user_mail, [
            'maxResults' => 1000,
            'q' => 'in:sent  נסגרה עסקה ' . $client_name
        ]);

        try {
            foreach ($list->getMessages() as $count => $message) {

                $message_id = $message->id;
                $optParamsGet2['format'] = 'full';
                $single_message = $gmail->users_messages->get($user_mail, $message_id, $optParamsGet2);

                $message_meta = $this->fetchBody($single_message);

                $files = $this->getAttachments($message_id, $single_message->getPayload()->parts, $gmail);

                //dd(Carbon::parse($message_meta['date'])->format('Y-m-d H:i:s'));

                $deal = Deal::firstOrCreate([
                    'gmail_msg_id' => $message_id
                ],[
                    //'date' => date('Y-m-d', strtotime($message_meta['date'])),
                    //'date' => Carbon::parse($message_meta['date'])->format('Y-m-d H:i:s'),
                    'type' => 'deal',
                    'bid_number' => 'na',
                    'gmail_msg_id' => $message_id,
                    'status' => Deal::REMOTE,
                    'payment_type' => 0
                ]);

                $deal->client()->associate(Client::where('id', $client_id)->first());

                if (!empty($files)) {
                    foreach ($files as $key => $value) {
                        $image_64 = $value['data'];
                        $deal_note = $this->get_string_between($message_meta['body'], '<body>', '</body>');
                        if($deal_note){
                            $deal->note = $deal_note;
                        }
                        $deal->addMediaFromBase64($image_64)->usingFileName(Str::random(40).'.pdf')->toMediaCollection('deal-document');
                    }
                }
                $deal->date = Carbon::parse($message_meta['date'])->format('Y-m-d H:i:s');
                $deal->save();


            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    function checkServiceAccountCredentialsFile()
    {
        // service account creds
        $application_creds = public_path('service-account-credentials.json');

        return file_exists($application_creds) ? $application_creds : false;
    }

    private function fetchBody($single_message)
    {
        $payload = $single_message->getPayload();
        $parts = $payload->getParts();
        $message_meta = $this->getMessageMetaFromHeaders($payload->getHeaders());
        $body = $payload->getBody();
        $FOUND_BODY = FALSE;
        if (!$FOUND_BODY) {
            foreach ($parts as $part) {
                if ($part['parts'] && !$FOUND_BODY) {
                    foreach ($part['parts'] as $p) {
                        if ($p['parts'] && count($p['parts']) > 0) {
                            foreach ($p['parts'] as $y) {
                                if (($y['mimeType'] === 'text/html') && $y['body']) {
                                    $FOUND_BODY = $this->decodeBody($y['body']->data);
                                    break;
                                }
                            }
                        } else if (($p['mimeType'] === 'text/html') && $p['body']) {
                            $FOUND_BODY = $this->decodeBody($p['body']->data);
                            break;
                        }
                    }
                }
                if ($FOUND_BODY) {
                    break;
                }
            }
        }
        if (!$FOUND_BODY) {
            foreach ($parts as $part) {
                if ($part['body'] && $part['mimeType'] === 'text/html') {
                    $FOUND_BODY = $this->decodeBody($part['body']->data);
                    break;
                }
            }
        }
        if (!$FOUND_BODY) {
            $FOUND_BODY = $this->decodeBody($body['data']);
        }
        if (!$FOUND_BODY) {
            foreach ($parts as $part) {
                if ($part['body']) {
                    $FOUND_BODY = $this->decodeBody($part['body']->data);
                    break;
                }
            }
        }
        if (!$FOUND_BODY) {
            $FOUND_BODY = '(No message)';
        }

        return [
            'body' => $FOUND_BODY,
            'date' => $message_meta['date']
        ];
    }

    private function getAttachments($message_id, $parts, $gmail)
    {
        $attachments = [];
        foreach ($parts as $part) {
            if (!empty($part->body->attachmentId)) {
                $attachment = $gmail->users_messages_attachments->get('me', $message_id, $part->body->attachmentId);
                $attachments[] = [
                    'filename' => $part->filename,
                    'mimeType' => $part->mimeType,
                    'data' => strtr($attachment->data, '-_', '+/')
                ];
            } else if (!empty($part->parts)) {
                $attachments = array_merge($attachments, $this->getAttachments($message_id, $part->parts, $gmail));
            }
        }
        return $attachments;
    }

    public function decodeBody($body)
    {
        $rawData = $body;
        $sanitizedData = strtr($rawData, '-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if (!$decodedMessage) {
            $decodedMessage = FALSE;
        }
        return $decodedMessage;
    }

    private function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function getMessageMetaFromHeaders($headers){
        $meta = [
            'from' => null,
            'to' => null,
            'date' => null,
            'subject' => null
        ];

        foreach ($headers as $_item) {
            switch ($_item->name) {
                case 'Date':
                    $meta['date'] = $_item->value;
                    break;
                case 'Message-ID':
                    $meta['message-id'] = $_item->value;
                    break;
            }

            if ($_item->name === 'From') {
                $meta['from'] = $_item->value;
            }

        }

        return $meta;
    }


}
