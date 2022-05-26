<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\OAuthRequest;
use App\Http\Resources\Front\UserResource;
use App\Repositories\OAuthProvider\OAuthProviderRepositoryInterface;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    protected $oAuthRepo;

    public function __construct(OAuthProviderRepositoryInterface $oAuthRepo)
    {
        $this->oAuthRepo = $oAuthRepo;
    }

    public function redirect(OAuthRequest $request,  string $provider)
    {
        return response()->json([
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()
        ]);
    }

    public function handleCallback(OAuthRequest $request, string $provider)
    {
        $providerUser =  Socialite::driver($provider)->stateless()->user();
        $user = $this->oAuthRepo->findOrCreateUser($provider, $providerUser);
        $user->setAppends(['rawAvatar']);
        auth()->login($user);
        return view('auth.oauth', ['user' => (new UserResource($user))->toJson()]);
        // return response()->json([
        //     'token' => $user->createToken($request->userAgent())->plainTextToken,
        // ]);
    }
}
