<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['required_without:images', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:8192', 'dimensions:min_width=100,min_height=100,max_width=6000,max_height=6000'],
            'images' => ['required_without:image', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpg,png,jpeg,gif,svg', 'max:8192', 'dimensions:min_width=100,min_height=100,max_width=6000,max_height=6000']
        ];
    }
}
