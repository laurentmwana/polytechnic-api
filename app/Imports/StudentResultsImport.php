<?php

namespace App\Imports;

use App\Models\Deliberation;
use App\Models\User;
use App\Notifications\SendErrorResult;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentResultsImport implements WithMultipleSheets
{
    public function __construct(protected array $sheetNames, protected Deliberation $deliberation)
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
