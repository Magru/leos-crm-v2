<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class TimelineController extends Controller{

    public function showTimeline($client){
        $client = Client::where('id', $client)->first();
        $client_conversations = $client->conversations;
        $client_deals = $client->deals;

        $timeline = $client_conversations->merge($client_deals)->sortByDesc('date');

        return view('timeline.show', [
            'name' => 'ציר זמן עבור ' . $client->name,
            'id' => $client->id,
            'timeline' => $timeline,
            'mails_count' => $client->countMails(),
            'calls_count' => $client->countCalls(),
        ]);
    }

}
