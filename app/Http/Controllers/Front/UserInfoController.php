<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\UserInformationUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserInfoController extends Controller
{
    public function update(UserInformationUpdateRequest $request)
    {
        /**
         * @var User
         */
        $user = $request->user();

        $attributes = $request->only([
            'first_name', 'last_name', 'email', 'gender', 'dob', 'phone', 'avatar',
        ]);

        if ($request->has('password'))
            array_merge($attributes, [
                'password' => Hash::make($request->password)
            ]);

        $user->update($attributes);
        return $user;
    }
}
