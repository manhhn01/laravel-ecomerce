<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\CategoryIndexResource;
use App\Http\Resources\PaginationCollection;

class CategoryPaginationResource extends PaginationCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => CategoryIndexResource::collection($this->collection),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'per_page' => intval($this->perPage()),
            'category_count' => $this->total(),
        ];
    }
}
