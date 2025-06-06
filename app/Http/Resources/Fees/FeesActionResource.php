<?php

namespace App\Http\Resources\Fees;

use App\Http\Resources\Level\LevelActionSecondaryResource;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeesActionResource extends JsonResource
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
            'amount' => $this->paid_at,
            'level' => new LevelActionSecondaryResource($this->level),
            'year' => new YearItemResource($this->yearAcademic),
            'created_at' => $this->created_at,
        ];
    }
}
