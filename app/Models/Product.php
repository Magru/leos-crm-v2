<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    use HasFactory;

    protected $fillable = [
        'name',
        'data',
        'notes',
        'price'
    ];

    protected $attributes = [
        'notes' => 'n/a',
    ];

    public function deals(){
        return $this->belongsToMany(Deal::class);
    }

}
