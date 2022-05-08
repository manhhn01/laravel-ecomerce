<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class AddressDestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['exists:addresses,id']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id')]);
    }
}
