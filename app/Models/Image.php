<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'imageable_type'
    ];

    protected $hidden = [
        'type',
        'imageable_type',
        'imageable_id',
        'created_at',
        'updated_at'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getImageAttribute($value)
    {
        return config('app.url') . "/api/$value";
    }
}
