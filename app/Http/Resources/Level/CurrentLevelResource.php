<?php

namespace App\Http\Resources\Level;

use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentLevelResource extends JsonResource
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
            'level' => new LevelActionResource($this->level),
            'year' => new YearItemResource($this->yearAcademic),
        ];
    }
}
