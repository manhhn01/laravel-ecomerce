<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
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
            'id' => $this->product->id,
            'variant_id' => $this->id,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'cart_quantity' => $this->pivot->quantity,
            'remain_quantity' => $this->quantity,
            'color' => $this->color,
            'size' => $this->size,
            'price' => $this->product->price,
            'sale_price' => $this->product->sale_price,
            'cover' => $this->product->cover,
        ];
    }
}
