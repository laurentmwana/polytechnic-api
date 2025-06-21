<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use App\Helpers\FollowStudent;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Level\LevelActionResource;
use App\Http\Resources\Teacher\TeacherActionResource;
use App\Http\Resources\Level\LevelActionSecondaryResource;

class CourseCollectionResource extends JsonResource
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
            'level' => new LevelActionSecondaryResource($this->level),
            'created_at' => $this->created_at,

        ];
    }
}
