<?php

namespace App\Repositories\Products;

use App\Exceptions\TableConstraintException;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function createVariants($product, $attributesArray)
    {
        return $product->variants()->createMany($attributesArray);
    }

    public function createImages($product, $attributesArray)
    {
        return $product->images()->createMany($attributesArray);
    }

    public function updateVariants($product, $attributesArr)
    {
        $variantIds = collect($attributesArr)->map(function ($variantAttributes) use ($product) {
            if (!isset($variantAttributes['id'])) {
                $variant = $product->variants()->create($variantAttributes);
                $variantAttributes['id'] = $variant->id;
            } else {
                $variant = $product->variants()->find($variantAttributes['id']);
                if (!empty($variant)) {
                    $variant->update($variantAttributes);
                }
            }
            return $variantAttributes['id'];
        });
        $product->variants()->whereNotIn('id', $variantIds)->delete();
    }

    public function updateImages($product, $attributesArr)
    {
        //
    }

    public function productsFilter($productsQuery, $filters)
    {
        if (isset($filters['price_min']))
            $productsQuery
                ->whereNested(function ($q) use ($filters) {
                    $q
                        ->where(function ($q) use ($filters) {
                            return $q
                                ->whereNotNull('sale_price')
                                ->where('sale_price', '>', $filters['price_min']);
                        })
                        ->orWhere(function ($q) use ($filters) {
                            return $q
                                ->whereNull('sale_price')
                                ->where('price', '>', $filters['price_min']);
                        });
                });

        if (isset($filters['price_max']))
            $productsQuery
                ->whereNested(function ($q) use ($filters) {
                    $q
                        ->where(function ($q) use ($filters) {
                            return $q
                                ->whereNotNull('sale_price')
                                ->where('sale_price', '<', $filters['price_max']);
                        })
                        ->orWhere(function ($q) use ($filters) {
                            return $q
                                ->whereNull('sale_price')
                                ->where('price', '<', $filters['price_max']);
                        });
                });

        if (isset($filters['color'])) {
            $colorTags = explode(',', $filters['color']);
            $productsQuery
                ->whereHas('tags', function ($q) use ($colorTags) {
                    return $q->whereIn('tags.name', $colorTags);
                });
        }

        if (isset($filters['size'])) {
            $sizeNames = explode(',', $filters['size']);
            $productsQuery->whereHas('variants', function ($q) use ($sizeNames) {
                $q->whereHas('size', function ($q) use ($sizeNames) {
                    $q->whereIn('sizes.name', $sizeNames);
                });
            });
        }

        if (isset($filters['category_id'])) {
            $productsQuery = $productsQuery->where('category_id', $filters['category_id']);
        }

        return $productsQuery;
    }

    public function filterAndPage($filters, $perPage = 30, $sortBy = 'created_at', $order = 'desc', $onlyPublic = true)
    {
        if ($onlyPublic)
            $products = Product::public()
                ->with('variants');
        else $products = Product::with('variants');

        if ($sortBy == 'price') {
            $products->orderByRaw('COALESCE(sale_price, price) ' . (strtolower($order) == 'asc' ? 'ASC' : 'desc'));
        } else {
            $products->orderBy($sortBy, $order);
        }

        if (!empty($filters)) {
            $products = $this->productsFilter($products, $filters);
        }

        return $products->paginate($perPage);
    }

    public function findByIdOrSku($id_sku)
    {
        return $this->model->where('id', $id_sku)->orWhere('sku', $id_sku)->first();
    }

    public function relatedProducts($product, $limit = 20)
    {
        return $this->model->with(['variants', 'tags'])->whereHas('tags', function ($q) use ($product) {
            return $q->whereIn('name', $product->tags->pluck('name'));
        })->limit($limit)->get();
    }
}
