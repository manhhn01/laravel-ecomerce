<?php

namespace App\Http\Requests\Front;

use App\Models\ProductVariant;
use App\Rules\VariantPublic;
use Illuminate\Foundation\Http\FormRequest;

class CartProductUpdateOneRequest extends FormRequest
{
    protected $maxQuantity;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_variant_id' => [
                'required', 'exists:product_variants,id', 'exists:cart_products,product_variant_id', new VariantPublic
            ],
            'quantity' => ['nullable', 'integer', 'min:1', "max:$this->maxQuantity"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['product_variant_id' => $this->route('id')]);
        $this->maxQuantity = optional(ProductVariant::find($this->product_variant_id))->quantity;
    }
}
