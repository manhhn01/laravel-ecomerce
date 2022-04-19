<?php

namespace App\Repositories\Orders;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function updateStatistic($order);
}
