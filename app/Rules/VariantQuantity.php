<?php

namespace App\Rules;

use App\Repositories\ProductVariants\ProductVariantsRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;

class VariantQuantity implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $productVariantRepo;
    public function __construct(ProductVariantsRepositoryInterface $productVariantRepo)
    {
        $this->productVariantRepo = $productVariantRepo;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->productVariantRepo->quantityCheck($value['product_variant_id'], $value['quantity']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The cart product quantity is invalid.';
    }
}
