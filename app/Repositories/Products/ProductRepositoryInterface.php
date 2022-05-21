<?php

namespace App\Repositories\Products;

use App\Exceptions\TableConstraintException;
use App\Models\User;
use App\Repositories\RepositoryInterface;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * @param Product $product
     * @param int $limit
     * @return Collection
     */
    public function relatedProducts($product, $limit = 20);

    /**
     * Check user have bought product before
     * @param Product $product
     * @param User $user
     * @return bool
     */
    public function haveBought($product, $user);

    /**
     * Check user have review product before
     * @param Product $product
     * @param User $user
     * @return bool
     */
    public function haveReviewed($product, $user);
}
