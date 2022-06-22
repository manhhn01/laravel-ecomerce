<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\OrderPaginationCollection;
use App\Http\Resources\OrderShowResource;
use App\Models\Order;
use App\Repositories\Orders\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepo;
    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterNames = [];
        return new OrderPaginationCollection($this->orderRepo->filterAndPage(
            $request->only($filterNames),
            $request->query('perpage', 30),
            $request->query('sortby', 'created_at'),
            $request->query('order', 'desc')
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        return new OrderShowResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->only(['status']));
        return $order;
    }
}
