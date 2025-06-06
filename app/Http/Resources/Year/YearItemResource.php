<?php

namespace App\Http\Resources\Year;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YearItemResource extends JsonResource
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
            'start' => $this->start,
            'end' => $this->end,
            'is_closed' => $this->is_closed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
