<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $type;

    public function __construct($resource, $type = null)
    {
        parent::__construct($resource);
        $this->type = $type;
    }
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
            'avatar' => $this->when($this->type !== 'password' || $this->type !== 'any', $this->provider_avatar, $this->avatar),
            'provider_avatar' => $this->provider_avatar,
            'phone' => $this->phone,
            'dob' => $this->dob,
            'joined_at' => $this->created_at,
        ];
    }
}
