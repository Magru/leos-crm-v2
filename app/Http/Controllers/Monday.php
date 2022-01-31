<?php

namespace App\Http\Controllers;

use App\Mail\DealCreated;
use App\Models\Deal;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use JetBrains\PhpStorm\NoReturn;
use TBlack\MondayAPI\MondayBoard;
use TBlack\MondayAPI\Token;

class Monday extends Controller{

    private MondayBoard $monday;

    #[NoReturn] public function __construct(){
        $this->monday = new MondayBoard(true);
        $token = new Token(env('MONDAY_TOKEN'));
        $this->monday->setToken($token);
    }

    public function getAllBoards(){
//        dd($this->monday->on('2219425041')->getBoards());
//        dd($this->monday->getBoards());
    }

    public function addItemsOnBoard($board_id, $id_group, $client_name, $id){
        $column_values = [
            'text' => $client_name,
            'person' => [
                'personsAndTeams' => [
                    [
                        'id' => '13018949',
                        'kind' => 'person'
                    ],
                    [
                        'id' => '26006020',
                        'kind' => 'person'
                    ]
                ]
            ]
        ];

        return $this->monday
            ->on($board_id)
            ->group($id_group)
            ->addItem( '#' . $id . ' ' . $client_name, $column_values );
    }

    public function addSubItemToItem($board_id, $id_group, $parent, $name){
        return $this->monday->on($board_id)
            ->group($id_group)
            ->addSubItem($parent, $name);
    }


    public function updateDealItemPulse($deal, $status, $item_id){
        $rec = 'leosmediainteractive_pulse_'.$item_id.'_d992228c72f8b3ee4af3__13018949@use1.mx.monday.com';
        Mail::to($rec)->send(new DealCreated($deal, $status));
    }
}
