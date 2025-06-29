<?php

namespace App\Http\Resources\Actuality;

use App\Http\Resources\Comment\CommentItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActualityCollectionResource extends JsonResource
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
            'comments' => CommentItemResource::collection($this->comments),
            'created_at' => $this->created_at,
        ];
    }
}
