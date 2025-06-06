<?php

namespace App\Http\Resources\Teacher;

use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Level\LevelActionResource;
use App\Http\Resources\Course\CourseActionResource;
use App\Http\Resources\Department\DepartmentActionResource;

class TeacherCollectionResource extends JsonResource
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
            'courses' => CourseActionResource::collection($this->courses),
            'created_at' => $this->created_at,
        ];
    }
}
