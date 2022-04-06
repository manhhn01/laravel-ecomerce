<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getProductsPage($amount, $category_id, $filter = null)
    {
        return Product::where('category_id', $category_id)->ofType($filter)->paginate($amount);
    }
}
