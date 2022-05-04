<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CartProductDestroyRequest as CartProductDestroyRequest;
use App\Http\Requests\Front\CartProductUpdateRequest;
use App\Http\Requests\Front\CartProductStoreRequest;
use App\Http\Requests\Front\CartProductUpdateOneRequest;
use App\Http\Resources\Front\CartProductResource;
use Illuminate\Http\Request;

class CartProductController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return CartProductResource::collection($user->cartProducts->load('product'));
    }

    public function store(CartProductStoreRequest $request)
    {
        $user = $request->user();

        $user->cartProducts()->attach(
            $request->product_variant_id,
            ['quantity' => $request->quantity ?? 1]
        );

        return CartProductResource::collection($user->cartProducts->load('product'));
    }

    public function update(CartProductUpdateRequest $request)
    {
        $user = $request->user();
        $products = collect($request->products);

        $user->cartProducts()->sync(
            $products->keyBy('product_variant_id')
        );

        return CartProductResource::collection($user->cartProducts->load('product'));
    }

    public function updateOne(CartProductUpdateOneRequest $request, $id)
    {
        $user = $request->user();

        $user->cartProducts()->updateExistingPivot($id, [
            'quantity' => $request->quantity
        ]);

        return CartProductResource::collection($user->cartProducts->load('product'));
    }

    public function destroy(CartProductDestroyRequest $request, $id)
    {
        $user = $request->user();

        $user->cartProducts()->detach($id);

        return CartProductResource::collection($user->cartProducts->load('product'));
    }
}
