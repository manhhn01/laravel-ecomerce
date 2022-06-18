<?php

namespace App\Repositories\Products;

use App\Exceptions\TableConstraintException;
use App\Models\Product;
use App\Models\User;
use App\Repositories\RepositoryInterface;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * @param Product $product
     * @param array $attributesArray
     * @return array
     * @throws QueryException
     */
    public function createVariants($product, $attributesArray);

    /**
     * @param Product $product
     * @param array $attributesArray
     * @return array
     * @throws QueryException
     */
    public function createImages($product, $attributesArray);

    /**
     * @param Product $product
     * @param array $attributesArr
     * @return Product
     */
    public function updateVariants($product, $attributesArr);

    /**
     * @param Product $product
     * @param array $attributesArr
     * @return Product
     */
    public function updateImages($product, $attributesArr);

    /**
     * @param Product $product
     * @param int $limit
     * @return Collection
     */
    public function relatedProducts($product, $limit = 20);

    /**
     * @param array $filters
     * @param int $perPage
     * @param string $sortBy
     * @param string $order
     * @param bool $onlyPublic
     * @return LengthAwarePaginator
     */
    public function filterAndPage($filters, $perPage = 30, $sortBy = 'created_at', $order = 'desc', $onlyPublic = true);
}
