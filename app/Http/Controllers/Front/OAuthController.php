<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\OAuthRequest;
use App\Http\Resources\Front\UserResource;
use App\Repositories\OAuthProvider\OAuthProviderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleCallback(OAuthRequest $request, string $provider)
    {
        $providerUser =  Socialite::driver($provider)->stateless()->user();
        $user = $this->oAuthRepo->findOrCreateUser($provider, $providerUser);
        Auth::login($user, true);
        return view('auth.oauth', ['user' => (new UserResource($user, 'provider'))->toJson()]);
    }
}
