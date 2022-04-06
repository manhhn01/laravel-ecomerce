<?php

namespace App\Repositories\Supplier;

use App\Repositories\RepositoryInterface;

interface SupplierRepositoryInterface extends RepositoryInterface
{
    /**
     * return products paginate.
     * @param $amount
     * @param $supplier_id
     * @param null $filter
     * @return mixed
     */
    public function getProductsPage($amount, $supplier_id, $filter);

    /**
     * find supplier by id or name.
     * @param $id_name
     * @return mixed
     */
    public function findByIdOrName($id_name);
}
