<?php

namespace App\Http\Resources;

use App\Http\Resources\Front\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderIndexResource extends JsonResource
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
            'buyer' => new UserResource($this->buyer, 'any'),
            'shipping_address' => $this->address->address,
            'province' => $this->address->ward->district->province->name,
            'district' => $this->address->ward->district->name,
            'ward' => $this->address->ward->name,
            'status' => $this->status,
            'shipped_date' => $this->shipped_date,
            'total_price' => $this->totalPrice,
            'shipping_fee' => 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment_method' => $this->payment_method,
        ];
    }
}
