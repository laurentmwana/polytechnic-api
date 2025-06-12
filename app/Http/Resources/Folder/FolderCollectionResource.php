<?php

namespace App\Http\Resources\Folder;

use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Level\LevelActionResource;
use App\Http\Resources\Course\CourseActionResource;
use App\Http\Resources\CourseFollow\CourseFollowCollectionResource;
use App\Http\Resources\Department\DepartmentActionResource;
use App\Http\Resources\Level\CurrentLevelResource;

class FolderCollectionResource extends JsonResource
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
            'firtname' => $this->firstname,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'historic_levels' => CurrentLevelResource::collection($this->historicLevels),
            'actual_level' => new CurrentLevelResource($this->actualLevel),
            'results' => [],
            'course_followeds' => CourseFollowCollectionResource::collection($this->courseFolloweds)
        ];
    }
}
