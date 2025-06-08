<?php

namespace App\Http\Resources\Deliberation;

use App\Http\Resources\Jury\JuryOnlyTeacherResource;
use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Level\LevelActionResource;

class DeliberationCollectionResource extends JsonResource
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
            'criteria' => $this->criteria,
            'semester' => $this->semester,
            'start_at' => $this->start_at,
            'year' => new YearItemResource($this->yearAcademic),
            'level' => new LevelActionResource($this->level),
            'juries' => JuryOnlyTeacherResource::collection($this->juries),
            'created_at' => $this->created_at,

        ];
    }
}
