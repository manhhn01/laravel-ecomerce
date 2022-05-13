<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\OAuthRequest;
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
        // dd($googleUser);
        $user = $this->oAuthRepo->findOrCreateUser($provider, $providerUser);

        //todo return view postmessage
        return response()->json([
            'token' => $user->createToken($request->userAgent())->plainTextToken,
        ]);
    }
}
