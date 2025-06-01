<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Level\CurrentLevelResource;

class StudentItemResource extends JsonResource
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
            'firstname' => $this->firstname,
            'phone' => $this->phone,
            'registration_token' => $this->registration_token,
            'gender' => $this->gender,
            'actual_level' => (new CurrentLevelResource($this->actualLevel)),
            'historic_levels' => CurrentLevelResource::collection($this->historicLevels),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
