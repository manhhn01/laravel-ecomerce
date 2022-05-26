<?php

namespace App\Repositories\OAuthProvider;

use App\Models\OAuthProvider;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Validation\ValidationException;

class OAuthProviderRepository extends BaseRepository implements OAuthProviderRepositoryInterface
{
    public function getModel()
    {
        return OAuthProvider::class;
    }

    public function findOrCreateUser($providerName, $providerUser)
    {
        $provider = $this
            ->model
            ->where('provider', $providerName)
            ->where('provider_user_id', $providerUser->getId())->first();

        if (!empty($provider)) {
            $provider->update([
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
            ]);
            return $provider->user;
        }

        if (User::where('email', $providerUser->getEmail())->exists()) {
            throw ValidationException::withMessages([
                'email' => 'This email has been taken'
            ]);
        } else {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'first_name' => $this->getFirstName($providerName, $providerUser->user),
                'last_name' => $this->getLastName($providerName, $providerUser->user),
                'provider_avatar' => $providerUser->getAvatar(),
                'email_verified_at' => now()
            ]);

            $user->providers()->create([
                'provider' => $providerName,
                'provider_user_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
            ]);

            return $user;
        }
    }

    /**
     * @param string $providerName
     * @param array $user
     * @return string
     */
    protected function getFirstName($providerName, $user)
    {
        switch (strtolower($providerName)) {
            case 'google':
                return $user['family_name'];
        }
    }

    /**
     * @param string $provider
     * @param array $user
     * @return string
     */
    protected function getLastName($provider, $user)
    {
        switch (strtolower($provider)) {
            case 'google':
                return $user['given_name'];
        }
    }
}
