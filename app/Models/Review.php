<?php

namespace App\Models;

use App\Traits\StatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, StatusScope;

    protected $fillable = [
        'comment', 'rating', 'like', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
