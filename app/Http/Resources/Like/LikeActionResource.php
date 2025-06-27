<?php

namespace App\Http\Resources\Like;

use App\Http\Resources\User\UserMeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeActionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserMeResource($this->user),
            'is_like' => $this->is_like,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
