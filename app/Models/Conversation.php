<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    const MAIL_TYPE = 'mail';
    const PHONE_TYPE = 'tel';


    protected $table = 'conversations';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $attributes = [
        'call_data' => []
    ];

    protected $appends = ['call_type'];


    protected $fillable = [
        'id',
        'type',
        'date',
        'body',
        'from',
        'to',
        'subject',
        'client_id',
        'call_data'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function callType(){
        $data = json_decode($this->call_data, true);
        return $data['call_type'];
    }

    public function callStatus(){
        $data = json_decode($this->call_data, true);
        return $data['call_status'] ?? null;
    }

    public function callUrl(){
        $data = json_decode($this->call_data, true);
        return $data['call_url'] ?? null;
    }
}
