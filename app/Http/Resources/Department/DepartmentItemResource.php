<?php

namespace App\Http\Resources\Department;

use App\Http\Resources\Level\LevelActionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Option\OptionActionResource;

class DepartmentItemResource extends JsonResource
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
            'levels' => LevelActionResource::collection($this->levels),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
