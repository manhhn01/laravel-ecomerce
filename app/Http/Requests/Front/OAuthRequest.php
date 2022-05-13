<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class OAuthRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider' => ['required', 'in:google,facebook,github']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['provider'=>$this->route('provider')]);
    }
}
