<?php

namespace App\Repositories\Products;

use App\Exceptions\TableConstraintException;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BaseRepository;

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

    public function page($perPage, $search = null, $status = null)
    {
        // Product::with('variants')
        //     ->status(1)
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(request()->query('perpage', 30));
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

    public function haveBought($product, $user)
    {
        return $product
            ->variants()
            ->whereHas('orders', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->exists();
    }

    public function haveReviewed($product, $user)
    {
        return $product->reviews()->where('user_id', $user->id)->exists();
    }
}
