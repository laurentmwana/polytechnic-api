<?php

namespace App\Http\Resources\Event;

use App\Http\Resources\Level\LevelActionResource;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventCollectionResource extends JsonResource
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
            'tags' => $this->tags,
            'start_at' => $this->start_at,
            'level' => new LevelActionResource($this->level),
            'year' => new YearItemResource($this->yearAcademic),
            'created_at' => $this->created_at,
        ];
    }
}
