<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'description', 'status'
    ];

    protected $appends = ['cover'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function coupon()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function options()
    {
        return $this->hasManyThrough(ProductOption::class, ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->morphMany(ProductImage::class, 'imageable');
    }

    public function getCoverAttribute()
    {
        return $this->images()->where('type', 'cover')->first('image');
    }

    // public function cover()
    // {
    //     return $this->images()->where('type', 'cover');
    // }
}
