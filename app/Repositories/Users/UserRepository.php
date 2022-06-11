<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function pageUsersByRole($role, $amount, $filter = null)
    {
        if (isset($filter)) {
            return $this->model->where('role', $role)->ofType($filter)->paginate($amount);
        } else {
            return $this->model->where('role', $role)->latest()->paginate($amount);
        }
    }

    public function filterAndPage($filters, $perPage = 30, $sortBy = 'created_at', $order = 'desc')
    {
        $users = $this->model->orderBy($sortBy, $order);
        if (!empty($filters)) {
            //todo
        }

        return $users->paginate($perPage);
    }
}
