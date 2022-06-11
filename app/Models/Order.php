<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'address_id',
        'coupon_id',
        'payment_method',
        'payment_signature',
        'request_id',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderProducts()
    {
        return $this->belongsToMany(ProductVariant::class)->withPivot(['price', 'quantity'])->withTimestamps();
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getTotalPriceAttribute()
    {
        // return 50000;// todo
        return $this->sub_total_price;
    }

    public function getSubTotalPriceAttribute()
    {
        return $this->orderProducts->sum(function($p){
            return $p->pivot->quantity * $p->pivot->price;
        });
        // return 50000;//todo
    }
}
