<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Deal extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const CANCELLED = 'בוטלה';
    public const PENDING = 'המתנה';
    public const APPROVED = 'בעבודה';
    public const REMOTE = 'נמשך ממייל';

    public const PAYMENT_TYPE = [
        0 => 'אין',
        1 => 'אשראי',
        2 => 'המחאות',
        3 => 'העברה בנקאית'
    ];

    public const MAIL_LIST = [
        'max.folko@gmail.com'
    ];



    protected $fillable = [
        'bid_number',
        'note',
        'client_review',
        'branch_review',
        'client_seniority',
        'employed_numbers',
        'gmail_msg_id',
        'type',
        'status',
        'total_price',
        'tax_total',
        'payment_type'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function payment(){
        return self::PAYMENT_TYPE[$this->payment_type];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('attributes', 'qty', 'price_per_single');
    }
}
