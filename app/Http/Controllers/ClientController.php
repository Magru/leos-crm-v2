<?php


namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;


class ClientController extends Controller
{

    public function index() :View{
        $clients = Client::all();
        return view('client.index', ['clients' => $clients]);
    }


    public function create() :View{
        return view('client.add-client', [
            'client' => null,
            'page_title' => 'לקוח חדש'
        ]);
    }


    public function store(Request $request){
        $client_name = $request->input('name');
        $contacts_field = $request->input('contact-persons');
        $rank = $request->input('rank');
        $contacts = null;

        if($contacts_field){
            foreach ($contacts_field as $_c){
                $contacts[] = [
                    'name' => $_c['contact-name'],
                    'email' => $_c['contact-email'],
                    'tel' => $_c['contact-tel'],
                    'role' => $_c['contact-role']
                ];
            }
        }
        $social = [
            'facebook' => $request->input('client-facebook'),
            'instagram' => $request->input('client-instagram'),
            'linkedin' => $request->input('client-linkedin'),
            'www' => $request->input('client-www')
        ];


        //@TODO Update Name
        $client = Client::updateOrCreate(
            [
                'name' => $client_name
            ],
            [
                'name' => $client_name,
                'contacts' => json_encode($contacts),
                'social' => json_encode($social),
                'website' => json_encode($social['www']),
                'dev_site' => json_encode([]),
                'domain_notes' => json_encode([]),
                'note' => json_encode([]),
                'rank' => $rank
            ]
        );

        return redirect()->route('client-index');

    }


    public function show($id):mixed {

        $client = Client::where('id', $id)->first();
        $client_conversations = $client->conversations;

        return view('client.show', [
            'name' => $client->name,
            'social' => json_decode($client->social, true),
            'id' => $client->id,
            'timeline' => $client_conversations
        ]);

    }


    public function edit($id){
        $client = Client::find($id);

        return view('client.add-client', [
            'client' => $client,
            'page_title' => 'ערוך לקוח'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }


    public function destroy($id){

        $client = Client::find($id);
        $client->delete();

        return redirect()->route('client-index');

    }

    public function fetch(Request $request){
        $data = [];
        if($request->has('q')){
            $data = Client::select("id","name")
                ->where('name','LIKE',"%". $request->input('q') . "%")
                ->get();
        }
        return response()->json($data);
    }
}
