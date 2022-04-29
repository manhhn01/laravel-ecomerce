<?php

namespace App\Repositories\CartProducts;

class CartProductRepository implements CartProductRepositoryInterface
{
    public function getUserCart($user)
    {
        return $user->cartProducts()->with(['product'])->get();
    }
}
