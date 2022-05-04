<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductIndexResource extends JsonResource
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
            'price' => $this->price,
            'salePrice' => $this->sale_price,
            'cover' => $this->cover,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'ratingAvg' => $this->whenAppended('rating_avg'),
            'options' => $this->whenAppended('options'),
            'variants' => $this->whenLoaded('variants'),
        ];
    }
}
