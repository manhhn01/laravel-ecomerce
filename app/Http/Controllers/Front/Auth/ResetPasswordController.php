<?php

namespace App\Http\Controllers\Front\Auth;

use App\Exceptions\InvalidResetCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Front\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Hash;
use Mail;
use Str;

class ResetPasswordController extends Controller
{
    public function sendResetMail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);

        $resetCode = strtoupper(Str::random(6));
        DB::table('password_resets')->updateOrInsert([
            'email' => $request->email,
            'reset_code' => Hash::make($resetCode),
            'created_at' => now(),
            'expire_at' => now()->addMinutes(15),
        ]);

        Mail::to($request->email)
            ->send(new ResetPassword($resetCode));

        return response()->json([
            'message'=>'Please check your email for password reset code.'
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'reset_code' => ['required', 'string', 'max:6']
        ]);

        try {
            $this->resetCodeCheck($request->only('email', 'reset_code'));

            return response()->json([
                'message' => 'Your reset code is valid'
            ]);
        } catch (InvalidResetCode $ex) {
            return response()->json([
                'message' => 'Your reset token is invalid',
                'errors' => $ex->getErrors()
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'min:8', 'max:50'],
            'reset_code' => ['required', 'max:6']
        ]);

        try {
            $this->resetCodeCheck($request->only('email', 'reset_code'));

            User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);

            DB::table('password_resets')->where('email', $request->email)->delete();
            User::where('email', $request->email)->first()->tokens()->delete();

            return response()->json([
                'message' => 'Password changed successfully'
            ]);
        } catch (InvalidResetCode $ex) {
            return response()->json([
                'message' => 'Your reset token is invalid',
                'errors' => $ex->getErrors()
            ]);
        }
    }

    protected function resetCodeCheck($attributes)
    {
        $passwordReset = DB::table('password_resets')->where('email', $attributes['email'])->first();
        if (!Hash::check($attributes['reset_code'], $passwordReset->reset_code)) {
            throw new InvalidResetCode([
                'token.match' => 'Your password reset code is not match our records',
            ]);
        }
        if ((new Carbon($passwordReset->expire_at))->isPast()) {
            throw new InvalidResetCode([
                'token.expired' => 'Your password reset code is expired',
            ]);
        }
    }
}
