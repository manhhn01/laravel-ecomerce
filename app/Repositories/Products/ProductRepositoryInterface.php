<?php

namespace App\Repositories\Products;

use App\Exceptions\TableConstraintException;
use App\Repositories\RepositoryInterface;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * get images by product_id.
     * @param $id
     * @return mixed
     */
    public function getImages($id);

    /**
     * find product by id or sku.
     * @param $id_sku
     * @return mixed
     */
    public function findByIdOrSku($id_sku);

    /**
     * @param $id
     * @return mixed
     * @throws TableConstraintException
     */
    public function delete($id);

    /**
     * @return QueryBuilder
     */
    public function wherePublic();
}
