<?php

namespace App\Repositories;

use Illuminate\Database\Query\Builder;

class OptionRepository extends Builder
{
    public function __construct() {}

    public function findPaginated()
    {
        return $this->with(['levels', 'department'])
            ->orderByDesc('updated_at')
            ->paginate();
    }

    public function findOneOrThrow(int $id)
    {
        return $this->with(['levels', 'department'])
            ->orderByDesc('updated_at')
            ->findOrFail($id);
    }
}
