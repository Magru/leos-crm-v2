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



    public function client(){
        return $this->belongsTo(Client::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
