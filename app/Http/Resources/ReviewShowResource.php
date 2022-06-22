<?php

namespace App\Http\Resources;

use App\Http\Resources\Front\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewShowResource extends JsonResource
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
            'rating' => $this->rating,
            'comment' => $this->comment,
            'likes_count' => $this->likes->count(),
            'user' => $this->whenLoaded('user', new UserShowResource($this->user)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
