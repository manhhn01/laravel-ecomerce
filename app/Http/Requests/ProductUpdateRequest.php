<?php

namespace App\Http\Requests;

use App\Rules\ImageUrl;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'max:250', 'string'],
            'slug' => ['nullable', 'string', 'unique:products,slug', 'max:250'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'description' => ['nullable', 'string', 'max:6500'],
            'status' => ['nullable', 'boolean'],
            'cover' => ['nullable'],
            'images' => ['nullable', 'array', 'min:1'],
            'images.*' => ['string', new ImageUrl()],
            'variants' => ['nullable', 'min:1', 'array'],
            'variants.*.sku' => ['nullable', 'string', 'unique:product_variants,sku', 'max:20'],
            'variants.*.color_id' => ['nullable', 'integer'],
            'variants.*.size_id' => ['nullable', 'integer'],
            'variants.*.cover' => ['nullable', 'string', new ImageUrl()],
            'variants.*.quantity' => ['nullable', 'min:0', 'max:10000'],
        ];
    }
}
