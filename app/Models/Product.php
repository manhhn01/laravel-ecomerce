<?php

namespace App\Models;

use App\Traits\StatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable, StatusScope;
    protected $fillable = [
        'name', 'slug', 'description', 'status'
    ];

    protected $with = ['reviews'];
    protected $appends = ['rating_avg'];

    protected $hidden = ['category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function coupon()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function publicReviews()
    {
        return $this->hasMany(Review::class)->status(1);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function rootCategory(){
        return $this->category->parent();
    }

    /**
     * @return string
     */

    public function getRatingAvgAttribute()
    {
        return round_down($this->reviews->where('status', 1)->avg('rating'), 0.5);
    }

    public function getCoverAttribute($value)
    {
        return asset("storage/$value");
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name
        ];
    }
}
