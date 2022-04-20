<?php

namespace App\Repositories\Categories;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * return products paginate.
     * @param $amount
     * @param $category_id
     * @param null $filter
     * @return mixed
     */
    public function getProductsPage($amount, $category_id, $filter);

    /**
     * return all root categories
     * @return mixed
     */
    public function allRoot();

    /**
     * return all root categories with children
     * @return mixed
     */
    public function allRootWithChildren();
}
