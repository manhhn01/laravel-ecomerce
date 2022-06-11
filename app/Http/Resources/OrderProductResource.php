<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'buy_quantity' => $this->pivot->quantity,
            'color' => $this->color,
            'size' => $this->size,
            'price' => $this->pivot->price,
            'cover' => $this->cover,
        ];
    }
}
