<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\Front\UserResource;
use App\Http\Resources\PaginationCollection;

class UserPaginationCollection extends PaginationCollection
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
            'data' => UserResource::collection($this->collection),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'per_page' => intval($this->perPage()),
            'users_count' => $this->total(),
        ];
    }
}
