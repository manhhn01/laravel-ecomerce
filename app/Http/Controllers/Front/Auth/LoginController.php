<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\LoginRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    function login(LoginRequest $request)
    {
        if ($request->hasSession()) {
            if (Auth::attempt($request->only(['email', 'password']))) {
                $request->session()->regenerate();
                return response('', 204);
            } else throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
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
