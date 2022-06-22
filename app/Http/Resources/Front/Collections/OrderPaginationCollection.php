<?php

namespace App\Http\Resources\Front\Collections;

use App\Http\Resources\Front\OrderResource;
use App\Http\Resources\PaginationCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderPaginationCollection extends PaginationCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => OrderResource::collection($this->collection),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'per_page' => intval($this->perPage()),
            'orders_count' => $this->total(),
        ];
    }
}
