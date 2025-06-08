<?php

namespace App\Http\Resources\Fees;

use Illuminate\Http\Request;
use App\Http\Resources\Year\YearItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Level\LevelActionSecondaryResource;

class FeesCollectionResource extends JsonResource
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
            'amount' => $this->amount,
            'level' => new LevelActionSecondaryResource($this->level),
            'year' => new YearItemResource($this->yearAcademic),
            'created_at' => $this->created_at,
        ];
    }
}
