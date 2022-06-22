<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\UserPaginationCollection;
use App\Http\Resources\Front\UserResource;
use App\Http\Resources\UserShowResource;
use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        $filterNames = [];
        return new UserPaginationCollection($this->userRepo->filterAndPage(
            $filterNames,
            $request->query('perpage', 30),
            $request->query('sortby', 'created_at'),
            $request->query('order', 'desc')
        ));
    }

    public function show(User $user)
    {
        return new UserShowResource($user->load('orders'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Xóa thành công']);
    }
}
