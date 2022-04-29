<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Cache;

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

    public function allRoot()
    {
        return $this->model->whereDoesntHave('parent')->get();
    }

    public function allRootWithChildren()
    {
        return $this->model->whereDoesntHave('parent')->with('children')->get();
    }

    public function allProducts($category)
    {
        return Cache::remember($category->id . '_products', 1800, function () use ($category) {
            $categoryIds = $category->children->pluck('id')->merge([$category->id]);
            return Product::status(1)
                ->with('variants')
                ->whereIn('category_id', $categoryIds)->get();
        });
    }

    public function allProductsPage($category, $filters, $perPage = 30, $sortBy = 'created_at', $order = 'desc')
    {
        $categoryIds = $category->children->pluck('id')->merge([$category->id]);
        $products =  Product::status(1)
            ->with('variants')
            ->whereIn('category_id', $categoryIds)
            ->orderBy($sortBy, $order);

        if (!empty($filters)) {
            $products = $this->productsFilter($products, $filters);
        }

        return collect($category)->merge([
            'children' => $category->children->makeHidden(['description', 'cover']),
            'products' => $products->paginate($perPage)->tap(function($products){
                $products->makeHidden(['reviews', 'publicReviews', 'laravel_through_key'])->append('options');
            }),
        ]);
    }

    public function productsFilter($productsQuery, $filter)
    {
        if (isset($filters['price_min']))
            $productsQuery
                ->where(function ($q) use ($filter) {
                    return $q
                        ->whereNotNull('sale_price')
                        ->where('sale_price', '>', $filter['price_min']);
                })
                ->orWhere(function ($q) use ($filter) {
                    return $q
                        ->whereNull('sale_price')
                        ->where('price', '>', $filter['price_min']);
                });

        if (isset($filters['price_max']))
            $productsQuery
                ->where(function ($q) use ($filter) {
                    return $q
                        ->whereNotNull('sale_price')
                        ->where('sale_price', '>', $filter['price_max']);
                })
                ->orWhere(function ($q) use ($filter) {
                    return $q
                        ->whereNull('sale_price')
                        ->where('price', '>', $filter['price_max']);
                });

        if (isset($filters['color'])) {
            $colors = explode(',', $filters['color']);
            $productsQuery
                ->whereHas('variants', function ($q) use($colors){
                    return $q->whereIn('color_id', $colors);
                });
        }

        if (isset($filters['size'])) {
            $sizes = explode(',', $filters['size']);
            $productsQuery
                ->whereHas('variants', function ($q) use($sizes){
                    return $q->whereIn('size_id', $sizes);
                });
        }

        if (isset($filters['category'])) {
            $productsQuery = $productsQuery->where('category_id', $filters['category']);
        }

        return $productsQuery;
    }
}
