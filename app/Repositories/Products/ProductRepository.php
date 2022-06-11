<?php

namespace App\Repositories\Products;

use App\Exceptions\TableConstraintException;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function create($attributes)
    {
        if ($attributes['category'] == 'add') {
            $category = Category::create([
                'name' => $attributes['new_category'],
                'description' => 'Danh mục ' . $attributes['new_category'],
            ]);
            $attributes['category'] = $category->id;
        }

        $product = parent::create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'price' => $attributes['price'],
            'status' => $attributes['status'],
            'sku' => $attributes['sku'],
            'quantity' => $attributes['quantity'],
            'category_id' => $attributes['category'],
        ]);

        if (!empty($attributes['images'])) {
            $product->images()->createMany($attributes['images']);
        }
    }

    public function update($id, $attributes)
    {
        $product = $this->model->findOrFail($id);

        if ($attributes['brand'] == 'add') {
            $brand = Brand::create([
                'name' => $attributes['new_brand'],
                'description' => 'Danh mục ' . $attributes['new_brand'],
            ]);
            $attributes['brand'] = $brand->id;
        }

        if ($attributes['category'] == 'add') {
            $category = Category::create([
                'name' => $attributes['new_category'],
                'description' => 'Danh mục ' . $attributes['new_category'],
            ]);
            $attributes['category'] = $category->id;
        }

        $product->update(
            [
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'brand_id' => $attributes['brand'],
                'price' => $attributes['price'],
                'status' => $attributes['status'],
                'sku' => $attributes['sku'],
                'quantity' => $attributes['quantity'],
                'category_id' => $attributes['category'],
            ]
        );

        if (!empty($attributes['images'])) {
            $product->images()->delete();
            $product->images()->createMany($attributes['images']);
        }
    }

    public function delete($id)
    {
        $product = $this->find($id);
        if ($product->orders()->exists()) {
            throw new TableConstraintException('Sản phẩm đã có trong đơn hàng, không thể xóa');
        }
        if ($product->receivedNotes()->exists()) {
            throw new TableConstraintException('Sản phẩm đã có trong phiếu nhập, không thể xóa');
        }
        parent::delete($id);
    }

    /* ------ */

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
