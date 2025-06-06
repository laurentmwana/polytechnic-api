<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use App\Http\Resources\User\UserSimpleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Level\CurrentLevelResource;

class StudentCollectionResource extends JsonResource
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
            'registration_token' => $this->registration_token,
            'gender' => $this->gender,
            'user' => new UserSimpleResource($this->user),
            'actual_level' => new CurrentLevelResource($this->actualLevel),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
