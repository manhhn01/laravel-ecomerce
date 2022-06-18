<?php

namespace App\Http\Requests;

use App\Rules\ImageUrl;
use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:250', 'string'],
            'slug' => ['required', 'string', 'unique:products,slug', 'max:250'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'description' => ['required', 'string', 'max:6500'],
            'status' => ['required', 'boolean'],
            'cover' => ['required'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['string', new ImageUrl()],
            'variants' => ['required', 'min:1', 'array'],
            'variants.*.sku' => ['required', 'string', 'unique:product_variants,sku', 'max:20'],
            'variants.*.color_id' => ['required', 'integer'],
            'variants.*.size_id' => ['required', 'integer'],
            'variants.*.cover' => ['required', 'string', new ImageUrl()],
            'variants.*.quantity' => ['required', 'min:0', 'max:10000'],
        ];
    }
}
