<?php

namespace App\Http\Resources\CourseFollow;

use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Course\CourseActionResource;
use App\Http\Resources\Student\StudentActionResource;

class CourseFollowCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student' => new StudentActionResource($this->student),
            'year' => new YearItemResource($this->yearAcademic),
            'course' => new CourseActionResource($this->course),
            'created_at' => $this->created_at
        ];
    }
}
