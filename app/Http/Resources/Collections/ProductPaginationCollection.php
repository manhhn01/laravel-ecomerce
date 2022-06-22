<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\PaginationCollection;
use App\Http\Resources\UserIndexResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductPaginationCollection extends PaginationCollection
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
            'data' => UserIndexResource::collection($this->collection),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'per_page' => intval($this->perPage()),
            'users_count' => $this->total(),
        ];
    }
}
