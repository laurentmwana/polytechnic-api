<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Level\LevelActionResource;
use App\Http\Resources\Teacher\TeacherActionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Year\YearItemResource;

class CourseActionResource extends JsonResource
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
            'code' => $this->code,
            'credits' => $this->credits,
            'semester' => $this->semester,
            'teacher' => new TeacherActionResource($this->teacher),
            'created_at' => $this->created_at,
        ];
    }
}
