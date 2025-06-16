<?php

namespace App\Imports;

use App\Http\Requests\ResultRequest;
use App\Models\Deliberation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentResultsImport implements WithMultipleSheets
{
    public function __construct(protected array $sheetNames, private Deliberation $deliberation)
    {
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->sheetNames as $name) {
            $sheets[$name] = new StudentSheetImport($this->deliberation);
        }

        return $sheets;
    }
}
