<?php

namespace App\Jobs;

use App\Events\AdminResultsEvent;
use App\Imports\StudentResultsImport;
use App\Models\Deliberation;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Notifications\SendErrorResult;

class StudentResultsPublisherJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public function __construct(
        private string $filePath,
        private Deliberation $deliberation,
        private User $user
    ) {}

    public function handle(): void
    {
        try {
            $spreadsheet = IOFactory::load($this->filePath);
            $sheetNames = $spreadsheet->getSheetNames();

            $studentImport = new StudentResultsImport($sheetNames, $this->deliberation);

            Excel::import($studentImport, $this->filePath);

            event(new AdminResultsEvent($this->deliberation, $this->user));
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'importation des résultats étudiants : " . $e->getMessage(), [
                'file' => $this->filePath,
                'deliberation_id' => $this->deliberation->id,
                'user_id' => $this->user->id,
                'trace' => $e->getTraceAsString()
            ]);

            $this->user->notify(new SendErrorResult("Une erreur s'est produite pendant l'importation : " . $e->getMessage()));

            throw $e;
        }
    }
}
