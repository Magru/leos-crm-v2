<?php

namespace App\Mail;

use App\Models\Deal;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DealCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $deal;
    private $type;

    public function __construct(Deal $deal, $type){
        $this->deal = $deal;
        $this->type = $type;
    }

    public function build(){

        if($this->type === Deal::APPROVED){

            $pivot_products = $this->deal->products()->get();
            $products = [];
            foreach ($pivot_products as $d){
                $products[$d->pivot->product_id] = [
                    'name' => Product::find($d->pivot->product_id)->name,
                    'qty' => $d->pivot->qty,
                    'price' => $d->pivot->price_per_single,
                    'attr' => json_decode($d->pivot->attributes, true),
                ];
            }

            $mail = $this->subject('הזמנה חדשה')->view('deal.mail.approved')->with([
                'dealID' => $this->deal->id,
                'link' => route('deal.edit', ['id' => $this->deal->id]),
                'client' => $this->deal->client->name,
                'rank' => $this->deal->client->rank,
                'bid_number' => $this->deal->bid_number,
                'client_review' => $this->deal->client_review,
                'branch_review' => $this->deal->branch_review,
                'client_seniority' => $this->deal->client_seniority,
                'employed_numbers' => $this->deal->employed_numbers,
                'total' => $this->deal->total_price + $this->deal->tax_total,
                'products' => $products,
                'monday' => $this->deal->monday_pulse
            ]);


            $files = $this->deal->getMedia('deal-document');
            foreach ($files as $f){
                $mail->attach($f->getPath());
            }

            return $mail;

        }

        return $this->subject('הזמנה חדשה לאישור')->view('deal.mail.new')->with([
            'dealID' => $this->deal->id,
            'link' => route('deal.edit', ['id' => $this->deal->id]),
            'client' => $this->deal->client->name,
            'total' => $this->deal->total_price + $this->deal->tax_total,
            'products' => ''
        ]);
    }
}
