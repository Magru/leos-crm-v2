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
        'status'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('attributes');
    }
}
