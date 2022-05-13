<?php

namespace App\Repositories\OAuthProvider;

use App\Models\User;
use App\Repositories\RepositoryInterface;
use Laravel\Socialite\Two\User as SocialiteUser;

interface OAuthProviderRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $providerName
     * @param SocialiteUser $user
     * @return User
     */
    public function findOrCreateUser($providerName, $user);
}
