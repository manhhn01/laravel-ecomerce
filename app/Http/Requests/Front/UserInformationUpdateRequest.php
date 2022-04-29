<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserInformationUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['min:2', 'max:50'],
            'last_name' => ['min:2', 'max:50'],
            'email' => ['email', 'unique:users,email'],
            'gender' => ['boolean'],
            'dob' => ['date', 'date_format:Y-m-d', 'before:today'],
            'phone' => ['regex:/^[+\d]?[0-9]{9,12}$/'],
            'password' => ['min:8', 'max:50'],
            'avatar' => [],
        ];
    }

    protected function prepareForValidation()
    {
        if(empty($this->all())){
            throw ValidationException::withMessages(["inputs" => "Invalid data"]);
        }
    }
}
