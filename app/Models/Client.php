<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Client extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'contacts',
        'social',
        'website',
        'dev_site',
        'domain_notes',
        'note',
        'proposal_files',
        'design_files',
        'text_files',
        'rank',
        'addresses'
    ];

    protected $attributes = [
        'addresses' => [],
    ];

    public function conversations(){
        return $this->hasMany(Conversation::class)->orderBy('date', 'desc');
    }

    public function countMails(){
        return $this->hasMany(Conversation::class)->where('type', 'mail')->count();
    }

    public function countCalls(){
        return $this->hasMany(Conversation::class)->where('type', 'tel')->count();
    }

    public function deals(){
        return $this->hasMany(Deal::class)->orderBy('date', 'desc');
    }

}
