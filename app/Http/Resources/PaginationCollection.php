<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\ResourceResponse;

class PaginationCollection extends ResourceCollection
{
    public function toResponse($request)
    {
        return (new ResourceResponse($this))->toResponse($request);
    }
}
