<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResource extends JsonResource
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
            'sale_price' => $this->sale_price,
            'description' => $this->description,
            'wished' => $this->wished,
            'cover' => $this->cover,
            'rating_avg' => $this->whenAppended('rating_avg'),
            'wishes_count' => $this->whenLoaded('wishlistUsers', $this->wishlistUsers->count()),
            'options' => $this->whenAppended('options'),
            'variants' => $this->whenLoaded('variants'),
            'images' => $this->whenLoaded('images'),
            'tags' => $this->whenLoaded('tags')->makeHidden('pivot'),
            'category' => $this->whenLoaded('categoryWithParent'),
            'reviews_count' => ($this->whenLoaded('publicReviews', $this->publicReviews->count())),
            'created_at' => $this->created_at,
        ];
    }
}
