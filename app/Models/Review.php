<?php

namespace App\Models;

use App\Traits\StatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, StatusScope;

    // protected $with = ['user:id,email,first_name,last_name,avatar'];

    protected $hidden = ['product_id', 'user_id'];

    protected $fillable = [
        'comment', 'rating', 'like', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
