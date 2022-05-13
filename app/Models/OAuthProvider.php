<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OAuthProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'provider_user_id',
        'access_token',
        'refresh_token'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
