<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'=>$this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'fullName' => $this->whenAppended('full_name'),
            'email' => $this->email,
            'gender' => $this->gender,
            'avatar' => $this->avatar,
            'phone' => $this->phone,
            'dob' => $this->dob,
            'joinedAt' => $this->created_at,
        ];
    }
}
