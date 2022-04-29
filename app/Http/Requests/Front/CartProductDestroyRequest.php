<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class CartProductDestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_variant_id' => [
                'required', 'exists:product_variants,id', 'exists:cart_products,product_variant_id',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['product_variant_id' => $this->route('id')]);
    }
}
