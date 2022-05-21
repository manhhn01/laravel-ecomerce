<?php

namespace App\Http\Requests;

use App\Rules\ProductPublic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'product_id' => ['required', 'exists:products,id', Rule::unique('wishlist_product')->where(function ($q) {
                return $q->where('user_id', auth('sanctum')->user()->id);
            }), new ProductPublic],
        ];
    }
}
