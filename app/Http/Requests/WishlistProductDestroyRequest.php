<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WishlistProductDestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => [
                'required', 'exists:products,id', 'exists:wishlist_products,product_id',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['product_id' => $this->route('id')]);
    }
}
