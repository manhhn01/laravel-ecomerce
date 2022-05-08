<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address' => $this->address,
            'geoinfo' => [
                'lat' => $this->lat,
                'lon' => $this->lon
            ],
            'phone' => $this->phone,
            'ward' => $this->ward,
            'district' => optional($this->ward)->district,
            'province' => optional(optional($this->ward)->district)->province
        ];
    }
}
