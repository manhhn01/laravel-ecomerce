<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserShowResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->whenAppended('full_name'),
            'email' => $this->email,
            'gender' => $this->gender,
            'avatar' => $this->avatar,
            'provider_avatar' => $this->provider_avatar,
            'phone' => $this->phone,
            'dob' => $this->dob,
            'orders' => $this->whenLoaded('orders'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
