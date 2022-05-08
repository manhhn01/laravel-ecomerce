<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['exists:addresses,id'],
            'lat' => ['nullable', 'numeric', 'max:99999999'],
            'lon' => ['nullable', 'numeric', 'max:99999999'],
            'address' => ['required', 'max:255'],
            'ward_id' => ['required', 'exists:wards,id'],
            'phone' => ['required', 'regex:/^[+\d]?[0-9]{9,12}$/'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id')]);
    }
}
