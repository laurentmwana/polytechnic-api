<?php

namespace App\Http\Resources\Department;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Option\OptionActionResource;

class DepartmentCollectionResource extends JsonResource
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
            'options' => OptionActionResource::collection($this->options),
            'created_at' => $this->created_at
        ];
    }
}
