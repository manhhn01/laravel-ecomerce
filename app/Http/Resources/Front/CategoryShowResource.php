<?php

namespace App\Http\Resources\Front;

use App\Http\Resources\Front\Collections\ProductPaginationCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryShowResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'cover' => $this->cover,
            'products' => new ProductPaginationCollection($this->when(isset($this->products), $this->products)),
            'children' => $this->whenLoaded('children'),
            'parent' => $this->parent,
            'products_count' => $this->products_count
        ];
    }
}
