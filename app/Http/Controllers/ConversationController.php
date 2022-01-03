<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Conversation;
use App\Models\User;
use Google_Service_Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Google_Client;
use Google_Service_Gmail;

class ConversationController extends Controller
{

    private string $admin_mail = 'dror@leos.co.il';

    public function fetchConversation(Client $client){


        $contacts = json_decode($client->contacts, true);
        $phone_nums = [];

        if ($contacts) {
            foreach ($contacts as $contact_item) {
                if ($contact_item['email']) {
                    $this->updateMailTimeLine($contact_item['email'], $client->id);
                }
                if ($contact_item['tel']) {
                    $phone_nums[] = $contact_item['tel'];
                }
            }
            $this->updateCallTimeLine($phone_nums, $client->id);
        }


        return redirect()->route('timeline.show', [$client->id]);
    }

    public function updateMailTimeLine($email, $client_id){
        $fetched_mails = 0;
        $users_mail = User::all()->pluck('email');
        dd($users_mail);
        if ($users_mail) {
            foreach ($users_mail as $mail) {
                $fetched_mails =  $this->fetchClientMailConversation($mail, $email, $client_id);
            }
        }

        return $fetched_mails;
    }

    public function updateCallTimeLine($phones, $client_id){

        $fetched_count = 0;

        $query_args = [
            'code' => env('VOICENTER_CODE'),
            'version' => 2,
            'format' => 'JSON',
            'phones' => $phones,
            'fields' => [
                'Date',
                'Type',
                'RecordURL',
                'DepartmentName',
                'DialStatus',
                'CallID',
                'CallerNumber',
                'TargetNumber',
                'RepresentativeName',
                'RepresentativeCode',
                'UserName',
                'DTMFData',
                'CustomData'
            ],
        ];
        $query = http_build_query($query_args, null, '&');
        $query = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $query);

        $response = Http::get('https://api1.voicenter.co.il/hub/cdr/?' . $query);

        if ($response->ok() && !empty($response['CDR_LIST'])) {
            foreach ($response['CDR_LIST'] as $_call_item) {

                $meta['from'] = $_call_item['CallerNumber'];
                $meta['to'] = $_call_item['TargetNumber'];
                $meta['date'] = $_call_item['Date'];
                $meta['subject'] = 'call';

                $call_data['call_url'] = $_call_item['RecordURL'];
                $call_data['call_type'] = $_call_item['Type'];
                $call_data['call_status'] = $_call_item['DialStatus'];
                $call_data['department'] = $_call_item['DepartmentName'];

                $call = $this->storeConversation('call-' . $_call_item['CallID'], Conversation::PHONE_TYPE, $meta, '', $client_id, json_encode($call_data));

                if($call->wasRecentlyCreated) $fetched_count++;

            }
        }

        return $fetched_count;

    }

    public function fetchClientMailConversation($user, $clientMail, $client_id){
        $client = new Google_Client();
        $fetched_count = 0;

        if ($credentials_file = $this->checkServiceAccountCredentialsFile()) {
            // set the location manually
            $client->setAuthConfig($credentials_file);
        } elseif (getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
            // use the application default credentials
            $client->useApplicationDefaultCredentials();
        } else {
            echo $this->missingServiceAccountDetailsWarning();
            return;
        }


        $client->setApplicationName("Client_Library_Examples");
        $client->setScopes([
            'https://mail.google.com',
            'https://www.googleapis.com/auth/gmail.readonly',
        ]);
        $client->setConfig('subject', $user);

        $gmail = new Google_Service_Gmail($client);


        $list = $gmail->users_messages->listUsersMessages($user, [
            'maxResults' => 5000,
            'q' => 'from:(' . $clientMail . ')'
        ]);

        try {
            while ($list->getMessages() != null) {

                foreach ($list->getMessages() as $count => $mlist) {

                    $message_id = $mlist->id;
                    $optParamsGet2['format'] = 'full';
                    $single_message = $gmail->users_messages->get($user, $message_id, $optParamsGet2);

                    $payload = $single_message->getPayload();
                    $parts = $payload->getParts();
                    $message_meta = $this->getMessageMetaFromHeaders($payload->getHeaders());
                    $body = $payload->getBody();
                    $FOUND_BODY = FALSE;
                    // If we didn't find a body, let's look for the parts
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
                    // let's save all the images linked to the mail's body:
                    if ($FOUND_BODY && count($parts) > 1) {
                        $images_linked = array();
                        foreach ($parts as $part) {
                            if ($part['filename']) {
                                array_push($images_linked, $part);
                            } else {
                                if ($part['parts']) {
                                    foreach ($part['parts'] as $p) {
                                        if ($p['parts'] && count($p['parts']) > 0) {
                                            foreach ($p['parts'] as $y) {
                                                if (($y['mimeType'] === 'text/html') && $y['body']) {
                                                    array_push($images_linked, $y);
                                                }
                                            }
                                        } else if (($p['mimeType'] !== 'text/html') && $p['body']) {
                                            array_push($images_linked, $p);
                                        }
                                    }
                                }
                            }
                        }
                        // special case for the wdcid...
                        preg_match_all('/wdcid(.*)"/Uims', $FOUND_BODY, $wdmatches);
                        if (count($wdmatches)) {
                            $z = 0;
                            foreach ($wdmatches[0] as $match) {
                                $z++;
                                if ($z > 9) {
                                    $FOUND_BODY = str_replace($match, 'image0' . $z . '@', $FOUND_BODY);
                                } else {
                                    $FOUND_BODY = str_replace($match, 'image00' . $z . '@', $FOUND_BODY);
                                }
                            }
                        }
                        preg_match_all('/src="cid:(.*)"/Uims', $FOUND_BODY, $matches);
                        if (count($matches)) {
                            $search = array();
                            $replace = array();
                            // let's trasnform the CIDs as base64 attachements
                            foreach ($matches[1] as $match) {
                                foreach ($images_linked as $img_linked) {
                                    foreach ($img_linked['headers'] as $img_lnk) {
                                        if ($img_lnk['name'] === 'Content-ID' || $img_lnk['name'] === 'Content-Id' || $img_lnk['name'] === 'X-Attachment-Id') {
                                            if ($match === str_replace('>', '', str_replace('<', '', $img_lnk->value))
                                                || explode("@", $match)[0] === explode(".", $img_linked->filename)[0]
                                                || explode("@", $match)[0] === $img_linked->filename) {
                                                $search = "src=\"cid:$match\"";
                                                $mimetype = $img_linked->mimeType;
                                                $attachment = $gmail->users_messages_attachments->get('me', $mlist->id, $img_linked['body']->attachmentId);
                                                $data64 = strtr($attachment->getData(), array('-' => '+', '_' => '/'));
                                                $replace = "src=\"data:" . $mimetype . ";base64," . $data64 . "\"";
                                                $FOUND_BODY = str_replace($search, $replace, $FOUND_BODY);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    // If we didn't find the body in the last parts,
                    // let's loop for the first parts (text-html only)
                    if (!$FOUND_BODY) {
                        foreach ($parts as $part) {
                            if ($part['body'] && $part['mimeType'] === 'text/html') {
                                $FOUND_BODY = $this->decodeBody($part['body']->data);
                                break;
                            }
                        }
                    }
                    // With no attachment, the payload might be directly in the body, encoded.
                    if (!$FOUND_BODY) {
                        $FOUND_BODY = $this->decodeBody($body['data']);
                    }
                    // Last try: if we didn't find the body in the last parts,
                    // let's loop for the first parts (text-plain only)
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

                    $conversation = $this->storeConversation('mail-' . $message_id, Conversation::MAIL_TYPE, $message_meta, $FOUND_BODY, $client_id);

                    if($conversation->wasRecentlyCreated) $fetched_count++;
                }

                if ($list->getNextPageToken() != null) {
                    $pageToken = $list->getNextPageToken();
                    $list = $gmail->users_messages->listUsersMessages($user, ['pageToken' => $pageToken, 'maxResults' => 1000]);
                } else {
                    break;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $fetched_count;
    }

    public function storeConversation($id, $type, $meta, $body, $client_id, $call_data = '{}')
    {
        return Conversation::firstOrCreate([
            'id' => $id,
        ], [
            'type' => $type,
            'date' => date('Y-m-d H:i:s', strtotime($meta['date'])),
            'body' => $body,
            'from' => $meta['from'],
            'to' => $meta['to'],
            'client_id' => $client_id,
            'subject' => $meta['subject'],
            'call_data' => $call_data
        ]);
    }


    private function missingServiceAccountDetailsWarning(){
        return 'Error';
    }


    function checkServiceAccountCredentialsFile(){
        $application_creds = public_path('service-account-credentials.json');
        return file_exists($application_creds) ? $application_creds : false;
    }


    public function decodeBody($body){
        $rawData = $body;
        $sanitizedData = strtr($rawData, '-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if (!$decodedMessage) {
            $decodedMessage = FALSE;
        }
        return $decodedMessage;
    }

    function getMessageMetaFromHeaders($headers){
        $recipients = [
            'from' => null,
            'to' => null,
            'date' => null,
            'subject' => null
        ];


        foreach ($headers as $_item) {
            switch ($_item->name) {
                case 'From':
                    $recipients['from'] = $_item->value;
                    break;
                case 'To':
                    $recipients['to'] = $_item->value;
                    break;
                case 'Subject':
                    $recipients['subject'] = $_item->value;
                    break;
                case 'Date':
                    $recipients['date'] = $_item->value;
                    break;
                case 'Message-ID':
                    $recipients['message-id'] = $_item->value;
                    break;
            }


            if ($_item->name === 'From') {
                $recipients['from'] = $_item->value;
            }

        }

        return $recipients;
    }

}
