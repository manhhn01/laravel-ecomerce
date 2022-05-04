<?php

namespace App\Repositories\CartProducts;

class CartProductRepository implements CartProductRepositoryInterface
{
    public function getUserCart($user)
    {
        return $user->cartProducts->load('product')->filter(function($variant){
            return $variant->product->isPublic();
        });
    }
}
