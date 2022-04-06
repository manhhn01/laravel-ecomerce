<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:50'],
            'gender' => ['required', 'boolean'],
            'dob' => ['nullable', 'date'],
            'phone' => ['nullable', 'regex:/^[+\d]?[0-9]{9,12}$/']
        ];
    }
}
