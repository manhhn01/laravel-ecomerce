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

    protected $appends = [
        'price',
        'sale_price',
        'rating'
    ];

    protected $with = ['variants:id,product_id,price,sale_price', 'cover'];

    protected $hidden = ['variants'];

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

    public function cover()
    {
        return $this->morphOne(ProductImage::class, 'imageable')->where('type', 'cover');
    }

    /**
     * @return string
     */
    public function getPriceAttribute()
    {
        if (!$this->hasManyVariants()) {
            return $this->variants()->first()->price . " đ";
        } else {
            $prices = collect();
            $this->variants->each(function ($variant) use ($prices) {
                $prices->push($variant->price, $variant->sale_price);
            });
            return "{$prices->min()} đ - {$prices->max()} đ";
        }
    }

    /**
     * @return string
     */
    public function getSalePriceAttribute()
    {
        if (!$this->hasManyVariants()) {
            return $this->variants->first()->sale_price;

        }
    }

    public function getRatingAttribute(){
        return round_down($this->reviews()->status(1)->avg('rating'), 0.5);
    }

    /**
     * @return bool
     */
    public function hasManyVariants()
    {
        if ($this->variants->count() > 1) {
            return true;
        }
        return false;
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name
        ];
    }
}
