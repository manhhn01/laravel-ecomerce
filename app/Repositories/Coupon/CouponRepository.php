<?php

namespace App\Repositories\Coupon;

use App\Models\Coupon;
use App\Repositories\BaseRepository;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    public function getModel()
    {
        return Coupon::class;
    }

    public function findByIdOrName($id_name)
    {
        return $this->model->where('id', '=', $id_name)->orWhere('name', '=', $id_name)->first();
    }
}
