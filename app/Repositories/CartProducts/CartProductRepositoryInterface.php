<?php

namespace App\Repositories\CartProducts;

use App\Models\User;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface CartProductRepositoryInterface
{
    /**
     * @param User $user
     * @return Collection
     */
    public function getUserCart($user);
}
