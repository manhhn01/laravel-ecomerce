<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    function login(LoginRequest $request)
    {
        if ($request->hasSession()) {
            $user = User::where('email', $request->email)->first();
            if ($user->role_id !== 0) {
                throw ValidationException::withMessages([
                    'email' => ['Vui long đăng nhập bằng tài khoản người quản trị.'],
                ]);
            } else
            if (Auth::attempt($request->only(['email', 'password']))) {
                $request->session()->regenerate();
                $request->session()->put('login_type', 'password');
                return response('', 204);
            } else throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user->role_id !== 0) {
                throw ValidationException::withMessages([
                    'email' => ['Vui long đăng nhập bằng tài khoản người quản trị.'],
                ]);
            } else
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return response()->json([
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ]);
        }
    }

    function logout(Request $request)
    {
        if ($request->hasSession()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response('', 204);
        }

        return abort(400);
    }
}
