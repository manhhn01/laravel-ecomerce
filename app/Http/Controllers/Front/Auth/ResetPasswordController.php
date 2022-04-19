<?php

namespace App\Http\Controllers\Front\Auth;

use App\Exceptions\InvalidResetCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ResetPasswordRequest;
use App\Http\Requests\Front\SendResetMailRequest;
use App\Http\Requests\Front\VerifyResetCodeRequest;
use Illuminate\Http\Request;
use App\Mail\Front\ResetPasswordMail;
use App\Models\User;
use App\Repositories\ResetPasswords\ResetPasswordRepositoryInterface;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Mail;
use Str;

class ResetPasswordController extends Controller
{
    protected $resetPasswordRepo;
    public function __construct(ResetPasswordRepositoryInterface $resetPasswordRepo)
    {
        $this->resetPasswordRepo = $resetPasswordRepo;
    }

    public function sendResetMail(SendResetMailRequest $request)
    {
        $resetCode = $this->resetPasswordRepo->generateCode();

        $this->resetPasswordRepo->clearPasswordReset($request->email);

        $this->resetPasswordRepo->create([
            'email' => $request->email,
            'reset_code' => Hash::make($resetCode),
            'created_at' => now(),
            'expire_at' => now()->addMinutes(15),
        ]);

        Mail::to($request->email)
            ->queue(new ResetPasswordMail($resetCode));

        return response()->json([
            'message' => 'Please check your email for password reset code.'
        ]);
    }

    public function verifyCode(VerifyResetCodeRequest $request)
    {
        try {
            $this->resetPasswordRepo->resetCodeCheck($request->only('email', 'reset_code'));

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

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $this->resetPasswordRepo->resetCodeCheck($request->only('email', 'reset_code'));

            User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);

            $this->resetPasswordRepo->clearPasswordReset($request->email);

            User::where('email', $request->email)->first()->tokens()->delete();

            if ($request->hasSession()) {
                $request->session()->regenerate();
            }

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
}
