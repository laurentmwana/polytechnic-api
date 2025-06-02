<?php

namespace App\Http\Resources\Level;

use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Option\OptionActionResource;

class LevelActionResource extends JsonResource
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
            'name' => $this->name,
            'alias' => $this->alias,
            'programme' => $this->programme,
            'option' => new OptionActionResource($this->option),
            'year' => new YearItemResource($this->yearAcademic),
        ];
    }
}
