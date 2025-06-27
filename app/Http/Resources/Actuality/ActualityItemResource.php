<?php

namespace App\Http\Resources\Actuality;

use App\Http\Resources\Comment\CommentItemResource;
use App\Http\Resources\Like\LikeActionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActualityItemResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'likes' => LikeActionResource::collection($this->likes),
            'comments' => CommentItemResource::collection($this->comments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
