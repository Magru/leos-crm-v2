<?php

namespace App\Mail;

use App\Models\Deal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DealCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $deal;

    public function __construct(Deal $deal){
        $this->deal = $deal;
    }

    public function build(){
        return $this->subject('הזמנה חדשה')->view('deal.mail.new')->with([
            'dealID' => $this->deal->id,
            'link' => route('deal.show', ['id' => $this->deal->id]),
            'client' => '',
            'products' => ''
        ]);
    }
}
