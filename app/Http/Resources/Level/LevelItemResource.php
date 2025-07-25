<?php

namespace App\Http\Resources\Level;

use App\Http\Resources\Department\DepartmentActionResource;
use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Option\OptionActionResource;

class LevelItemResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
