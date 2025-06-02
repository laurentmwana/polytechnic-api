<?php

namespace App\Http\Resources\Jury;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Teacher\TeacherActionResource;
use App\Http\Resources\Deliberation\DeliberationActionResource;

class JuryActionResource extends JsonResource
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
            'deliberation' => new DeliberationActionResource($this->deliberation),
            'teacher' => new TeacherActionResource($this->teacher),
        ];
    }
}
