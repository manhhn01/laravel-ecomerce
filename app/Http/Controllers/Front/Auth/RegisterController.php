<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\RegisterRequest;
use App\Models\User;
use Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $attributes = $request->except('password');
        $attributes['password'] = Hash::make($request->password);

        return User::create($attributes);
    }
}
