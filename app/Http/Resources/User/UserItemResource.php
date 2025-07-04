<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Student\StudentActionResource;

class UserItemResource extends JsonResource
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
            'email' => $this->email,
            'isEmailVerified' => $this->hasVerifiedEmail(),
            'roles' => $this->roles,
            'student' => new StudentActionResource($this->student),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
