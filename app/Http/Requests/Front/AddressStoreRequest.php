<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lat' => ['nullable', 'numeric', 'max:180'],
            'lon'=>['nullable', 'numeric', 'max:180'],
            'address' => ['required', 'max:255'],
            'ward_id' => ['required', 'exists:wards,id'],
            'phone' => ['required', 'regex:/^[+\d]?[0-9]{9,12}$/'],
        ];
    }
}
