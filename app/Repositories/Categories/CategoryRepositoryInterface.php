<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Query\Builder;

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

    /**
     * return category's products
     * @return Collection
     * @param Category $category
     * @param array $filter
     */
    public function allProducts($category);

    /**
     * return category's products with pagination
     * @param Category $category
     * @param array $filters
     * @param int $perPage
     * @param string $sortBy
     * @param string $order
     * @param bool $onlyPublic
     * @return Collection
     */
    public function allProductsPage($category, $filters, $perPage = 30, $sortBy = 'created_at', $order = 'desc', $onlyPublic = true);

    /**
     * @param Builder $productsQuery
     * @param array $filters
     * @return Builder
     */
    public function productsFilter($productsQuery, $filters);
}
