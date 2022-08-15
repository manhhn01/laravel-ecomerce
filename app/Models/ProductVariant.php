<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'sku', 'quantity', 'cover', 'color_id', 'size_id'
    ];

    protected $with = [
        'color', 'size'
    ];

    protected $hidden = [
        'product_id',
        'color_id',
        'size_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'color_id' => 'integer',
        'size_id' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function getCoverAttribute($value)
    {
        return config('app.product_image_url') . "/$value";
    }
}
