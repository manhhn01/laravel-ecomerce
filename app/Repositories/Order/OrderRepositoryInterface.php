<?php

namespace App\Repositories\Order;

use App\Exceptions\ExpiredCouponException;
use App\Exceptions\InvalidQuantityException;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function updateStatistic($order);
}
