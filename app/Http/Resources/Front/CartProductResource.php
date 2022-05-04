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
            'variantId' => $this->id,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'cartQuantity' => $this->pivot->quantity,
            'remainQuantity' => $this->quantity,
            'color' => $this->color,
            'size' => $this->size,
            'price' => $this->product->price,
            'salePrice' => $this->product->sale_price,
        ];
    }
}
