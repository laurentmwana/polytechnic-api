<?php

namespace App\Repositories;

use Illuminate\Database\Query\Builder;

class DepartmentRepository extends Builder
{
    public function __construct() {}

    public function findPaginated()
    {
        return $this->with(['options'])
            ->orderByDesc('updated_at')
            ->paginate();
    }

    public function findOneOrThrow(int $id)
    {
        return $this->with(['options'])
            ->orderByDesc('updated_at')
            ->findOrFail($id);
    }
}
