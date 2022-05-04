<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WishlistProductStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => ['required', 'exists:products,id', 'unique:wishlist_products'],
        ];
    }
}
