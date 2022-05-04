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

    protected $hidden = ['category_id'];

    protected $with = ['reviews'];

    protected $appends = ['rating_avg', 'options'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryWithParent()
    {
        return $this->category()->with('parent');
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

    public function rootCategory()
    {
        return $this->category->parent();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function getRatingAvgAttribute()
    {
        return round_down($this->reviews->where('status', 1)->avg('rating'), 0.5);
    }

    public function getCoverAttribute($value)
    {
        return asset("storage/$value");
    }

    public function getOptionsAttribute()
    {
        $colors = collect();
        $sizes = collect();

        $this->variants->each(function ($variant) use ($colors, $sizes) {
            $colors = $colors->push(['id' => $variant->color->id, 'name' => $variant->color->name]);
            $sizes = $sizes->push(['id' => $variant->size->id, 'name' => $variant->size->name]);
        });

        return [
            'colors' => $colors->unique(function ($color) {
                return $color['id'];
            })->values(),
            'sizes' => $sizes->unique(function ($size) {
                return $size['id'];
            })->values()
        ];
    }

    public function getRelatedProductsAttribute()
    {
        return self::whereHas('tags', function ($q) {
            return $q->whereIn('name', $this->tags->pluck('name'));
        })->limit(20)->get();
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name
        ];
    }
}
