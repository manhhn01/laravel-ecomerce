<?php

namespace App\Repositories\Brands;

use App\Models\Brand;
use App\Models\Product;
use App\Repositories\BaseRepository;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function getModel()
    {
        return Brand::class;
    }

    public function getProductsPage($amount, $supplier_id, $filter = null)
    {
        if (isset($filter)) {
            return Product::where('supplier_id', $supplier_id)->ofType($filter)->paginate($amount);
        } else {
            return Product::orderByDesc('created_at')->paginate($amount);
        }
    }

    public function findByIdOrName($id_name)
    {
        return $this->model->where('id', '=', $id_name)->orWhere('name', '=', $id_name)->first();
    }
}
