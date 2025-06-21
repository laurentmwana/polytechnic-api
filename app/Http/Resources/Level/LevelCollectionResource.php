<?php

namespace App\Http\Resources\Level;

use App\Http\Resources\Department\DepartmentActionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelCollectionResource extends JsonResource
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
        ];
    }
}
