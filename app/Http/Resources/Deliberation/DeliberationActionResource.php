<?php

namespace App\Http\Resources\Deliberation;

use App\Http\Resources\Level\LevelActionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Year\YearItemResource;

class DeliberationActionResource extends JsonResource
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
            'start_at' => $this->start_at,
            'semester' => $this->semester,
            'year' => new YearItemResource($this->yearAcademic),
            'level' => new LevelActionResource($this->level),
            'created_at' => $this->created_at,
        ];
    }
}
