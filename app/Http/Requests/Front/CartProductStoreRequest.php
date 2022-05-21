<?php

namespace App\Http\Requests\Front;

use App\Rules\VariantPublic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'product_variant_id' => ['required', 'exists:product_variants,id', Rule::unique('cart_product')->where(function ($q) {
                return $q->where('user_id', auth('sanctum')->user()->id);
            }), new VariantPublic],
            'quantity' => ['nullable', 'integer', 'min:1']
        ];
    }
}
