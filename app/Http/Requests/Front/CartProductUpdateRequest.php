<?php

namespace App\Http\Requests\Front;

use App\Rules\VariantPublic;
use App\Rules\VariantQuantity;
use Illuminate\Foundation\Http\FormRequest;

class CartProductUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => ['nullable', 'array', 'min:0'],
            'products.*' => [resolve(VariantQuantity::class)],
            'products.*.product_variant_id' => ['required', 'exists:product_variants,id', 'distinct', new VariantPublic],
            'products.*.quantity' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
