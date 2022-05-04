<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistProductDestroyRequest;
use App\Http\Requests\WishlistProductStoreRequest;
use App\Http\Requests\WishlistProductUpdateRequest;
use App\Http\Resources\Front\WishlistProductIndexResource;
use Illuminate\Http\Request;

class WishlistProductController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return WishlistProductIndexResource::collection($user->wishlistProducts);
    }

    public function store(WishlistProductStoreRequest $request)
    {
        $user = $request->user();

        $user->wishlistProducts()->attach(
            $request->product_id
        );

        return WishlistProductIndexResource::collection($user->wishlistProducts);
    }

    public function update(WishlistProductUpdateRequest $request)
    {
        $user = $request->user();
        $products = collect($request->products);

        $user->wishlistProducts()->sync(
            $products->pluck('product_id')
        );

        return WishlistProductIndexResource::collection($user->wishlistProducts);
    }

    public function destroy(WishlistProductDestroyRequest $request, $id)
    {
        $user = $request->user();

        $user->wishlistProducts()->detach($id);

        return WishlistProductIndexResource::collection($user->wishlistProducts);
    }
}
