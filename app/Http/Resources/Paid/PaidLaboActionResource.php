<?php

namespace App\Http\Resources\Paid;

use Illuminate\Http\Request;
use App\Http\Resources\Fees\FeesActionResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Student\StudentActionResource;

class PaidLaboActionResource extends JsonResource
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
            'is_paid' => $this->is_paid,
            'paid_at' => $this->paid_at,
            'student' => new StudentActionResource($this->student),
            'laboratory' => new FeesActionResource($this->feesLaboratory),
        ];
    }
}
