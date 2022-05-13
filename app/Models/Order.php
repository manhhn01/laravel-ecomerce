<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_id',
        'coupon_id',
        // 'payment_method',
    ];

    public function buyer(){
        return $this->belongsTo(User::class);
    }

    public function orderProducts(){
        return $this->belongsToMany(ProductVariant::class)->withPivot(['price', 'quantity'])->withTimestamps();
    }

    public function getTotalPriceAttribute(){
        return ;// todo
    }

    public function getSubTotalPriceAttribute(){
        return ;//todo
    }
}
