<?php

namespace App\Repositories\ResetPasswords;

use App\Exceptions\InvalidResetCode;
use App\Models\PasswordReset;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;
use Hash;
use Str;

class ResetPasswordRepository extends BaseRepository implements ResetPasswordRepositoryInterface
{
    public function getModel()
    {
        return PasswordReset::class;
    }

    public function resetCodeCheck($attributes)
    {
        $passwordReset = $this->findByEmail($attributes['email']);
        if(empty($passwordReset)){
            throw new InvalidResetCode([
                'token.exist' => 'This email does not have any reset code.',
            ]);
        }

        if (!Hash::check($attributes['reset_code'], $passwordReset->reset_code)) {
            throw new InvalidResetCode([
                'token.match' => 'Your password reset code is not match our records',
            ]);
        }

        if ((new Carbon($passwordReset->expire_at))->isPast()) {
            throw new InvalidResetCode([
                'token.expire' => 'Your password reset code is expired',
            ]);
        }
    }

    public function clearPasswordReset($email)
    {
        $this->model->where('email', $email)->delete();
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->latest()->first();
    }

    public function generateCode()
    {
        return strtoupper(Str::random(6));
    }
}
