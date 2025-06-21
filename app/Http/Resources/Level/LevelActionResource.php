<?php

namespace App\Http\Resources\Level;

use App\Http\Resources\Department\DepartmentActionResource;
use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'department' => new DepartmentActionResource($this->department),
            'year' => new YearItemResource($this->yearAcademic),
        ];
    }
}
