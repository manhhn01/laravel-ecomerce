<?php

namespace App\Repositories\ProductVariants;

use App\Repositories\RepositoryInterface;

interface ProductVariantsRepositoryInterface extends RepositoryInterface
{
    /**
     * @param mixed $id
     * @param mixed $inputQuantity
     * @return bool
     */
    function quantityCheck($id, $inputQuantity);
}
