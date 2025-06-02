<?php

namespace App\Http\Resources\Teacher;

use App\Http\Resources\Department\DepartmentActionResource;
use App\Http\Resources\Level\LevelActionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Year\YearItemResource;

class TeacherActionResource extends JsonResource
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
            'gender' => $this->gender,
            'department' => new DepartmentActionResource($this->department),
            'created_at' => $this->created_at,
        ];
    }
}
