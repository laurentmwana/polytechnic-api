<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Student\StudentActionResource;

class UserCollectionResource extends JsonResource
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
            'student' => $this->student ? new StudentActionResource($this->student) : null,
            'created_at' => $this->created_at,
        ];
    }
}
