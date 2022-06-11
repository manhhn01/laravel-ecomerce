<?php

namespace App\Repositories\Orders;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function filterAndPage($filters, $perPage = 30, $sortBy = 'created_at', $order = 'desc');
}
