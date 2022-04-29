<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class CartProductStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_variant_id' => ['required', 'exists:product_variants,id', 'unique:cart_products'],
            'quantity'=> ['nullable', 'integer', 'min:1']
        ];
    }
}