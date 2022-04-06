<?php

namespace App\Repositories\Coupon;

use App\Repositories\RepositoryInterface;

interface CouponRepositoryInterface extends RepositoryInterface
{
    /**
     * find coupon by id or name.
     * @param $id_name
     * @return mixed
     */
    public function findByIdOrName($id_name);
}
