<?php

namespace App\Http\Resources\Level;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelActionSecondaryResource extends JsonResource
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

        ];
    }
}
