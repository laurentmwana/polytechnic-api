<?php

namespace App\Http\Resources\Deliberation;

use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Level\LevelActionResource;
use App\Http\Resources\Student\StudentActionResource;

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
            'year' => new YearItemResource($this->yearAcademic),
            'level' => new LevelActionResource($this->level),
            'created_at' => $this->created_at,

        ];
    }
}
