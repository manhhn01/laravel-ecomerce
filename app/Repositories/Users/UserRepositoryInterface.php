<?php

namespace App\Repositories\Users;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * page user by role id
     */
    public function pageUsersByRole($role, $amount, $filter);
}
