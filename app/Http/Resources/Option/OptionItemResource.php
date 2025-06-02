<?php

namespace App\Http\Resources\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Department\DepartmentActionResource;
use App\Http\Resources\Level\LevelActionSecondaryResource;

class OptionItemResource extends JsonResource
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
            'levels' => LevelActionSecondaryResource::collection($this->levels),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
