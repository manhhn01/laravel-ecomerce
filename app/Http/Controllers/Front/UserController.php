<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\UserUpdateRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return $request->user();
    }

    public function update(UserUpdateRequest $request)
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

    public function uploadAvatar(ImageUploadRequest $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filePath = "images/users/" . $fileName . '|' . time() . '.jpg';
            Image::make($file)
                ->fit(300)
                ->save(
                    Storage::disk('public')->path($filePath),
                    90,
                    'jpg'
                );
            return response()->json([
                'filename' => $filePath
            ]);
        }
    }
}
