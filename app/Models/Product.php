<?php

namespace App\Models;

use App\Traits\StatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable, StatusScope;
    protected $fillable = ['name', 'price', 'sale_price', 'slug', 'description', 'status', 'cover'];
    protected $hidden = ['category_id'];
    protected $appends = ['rating_avg', 'options', 'wished'];
    protected $casts = [
        'price' => 'float',
        'sale_price' => 'float'
    ];

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

    public function wishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishlist_product')->withTimestamps();
    }

    public function getRatingAvgAttribute()
    {
        return round_down($this->reviews->where('status', 1)->avg('rating'), 0.5);
    }

    public function getCoverAttribute($value)
    {
        return config('app.url') . "/api/$value";
    }

    public function getOptionsAttribute()
    {
        $colors = collect();
        $sizes = collect();

        $this->variants->each(function ($variant) use ($colors, $sizes) {
            $colors = $colors->push(['id' => $variant->color_id, 'name' => $variant->color->name, 'cover' => $variant->cover]);
            $sizes = $sizes->push(['id' => $variant->size_id, 'name' => $variant->size->name]);
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

    public function getSoldAttributes()
    {
        $variantIds = $this->variants->pluck('id')->toArray();
        return \DB::table('order_product_variant')->sum('quantity');
        //todo
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            // 'description' => $this->description
        ];
    }

    public function isPublic()
    {
        return $this->status == 1;
    }

    public function getWishedAttribute()
    {
        if (!empty(auth('sanctum')->user()))
            return $this->wishlistUsers->contains(auth('sanctum')->user());
    }
}
