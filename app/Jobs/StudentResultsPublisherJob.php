<?php

namespace App\Jobs;

use App\Events\AdminResultsEvent;
use App\Imports\StudentResultsImport;
use App\Models\Deliberation;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StudentResultsPublisherJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $filePath,
        private Deliberation $deliberation,
        private User $user
        )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $spreadsheet = IOFactory::load($this->filePath);
        $sheetNames = $spreadsheet->getSheetNames();

        Excel::import(new StudentResultsImport(
            $sheetNames, $this->deliberation), $this->filePath);

        event(new AdminResultsEvent($this->deliberation, $this->user));

    }
}
