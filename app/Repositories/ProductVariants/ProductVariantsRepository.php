<?php

namespace App\Repositories\ProductVariants;

use App\Models\ProductVariant;
use App\Repositories\BaseRepository;

class ProductVariantsRepository extends BaseRepository implements ProductVariantsRepositoryInterface
{
    public function getModel()
    {
        return ProductVariant::class;
    }

    public function quantityCheck($id, $inputQuantity)
    {
        return ($this->model->without(['color', 'size'])->whereId($id)->first()->quantity >= $inputQuantity);
    }
}
