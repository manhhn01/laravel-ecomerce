<?php

namespace App\Http\Resources\Front\Collections;

use App\Http\Resources\Front\ProductIndexResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\ResourceResponse;

class ProductPaginationCollection extends ResourceCollection
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
            'data' => ProductIndexResource::collection($this->collection),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'per_page' => intval($this->perPage()),
        ];
    }

    public function toResponse($request)
    {
        // if ($this->resource instanceof AbstractPaginator || $this->resource instanceof AbstractCursorPaginator) {
        //     return $this->preparePaginatedResponse($request);
        // }
        // return parent::toResponse($request);
        return (new ResourceResponse($this))->toResponse($request);
    }
}
