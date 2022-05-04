<?php

namespace App\Http\Requests;

use App\Rules\ProductPublic;
use Illuminate\Foundation\Http\FormRequest;

class WishlistProductUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'exists:products,id', 'distinct', new ProductPublic],
        ];
    }
}
