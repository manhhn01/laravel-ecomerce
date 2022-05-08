<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ward_id',
        'address',
        'phone',
        'lat',
        'lon'
    ];

    function subdivision(){
        return $this->belongsTo(Ward::class);
    }

    function ward() {
        return $this->belongsTo(Ward::class);
    }
}
