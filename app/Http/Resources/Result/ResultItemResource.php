<?php

namespace App\Http\Resources\Result;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Student\StudentActionResource;
use App\Http\Resources\Deliberation\DeliberationActionResource;

class ResultItemResource extends JsonResource
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
            'student' => new StudentActionResource($this->student),
            'is_eligible' => $this->is_eligible,
            'is_paid_academic' => $this->is_paid_academic,
            'is_paid_labo' => $this->is_paid_labo,
            'is_paid_enrollment' => $this->is_paid_enrollment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
