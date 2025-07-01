<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Deliberation;
use App\Models\Result;
use App\Notifications\ResultAvailable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;
use App\Services\Upload\PublicFileUpload;

class StudentSheetImport implements ToCollection
{
    public function __construct(private Deliberation $deliberation) {}

    public function collection(Collection $rows)
    {
        $studentData = $this->extractStudentData($rows);

        if (!$studentData) {
            Log::warning('Données étudiant manquantes ou invalides.');
            throw new \RuntimeException("Le fichier Excel ne contient pas les données de l'étudiant.");
        }

        $courses = $this->extractCourses($rows);
        $summary = $this->extractSummary($rows);

        $matricule = $studentData['matricule'];
        $eligible = strtoupper(trim($studentData['eligible'])) === 'OUI';
        $paidAcademic = strtoupper(trim($summary['frais_academique'] ?? '')) === 'OUI';
        $paidLabo = strtoupper(trim($summary['frais_labo'] ?? '')) === 'OUI';
        $enrollment = strtoupper(trim($summary['enrollment'] ?? '')) === 'OUI';

        if (!$matricule) {
            Log::warning('Matricule manquant dans le fichier Excel', [
                'studentData' => $studentData,
                'file_content' => $rows->take(10)->toArray(),
            ]);

            throw new \RuntimeException("Le matricule est manquant dans le fichier Excel.");
        }

        $student = $this->findStudent($matricule);

        if (!$student) {
            $errorMessage = "Étudiant avec le matricule {$matricule} non trouvé dans la promotion « {$this->deliberation->level->name} » pour l'année académique.";

            Log::error($errorMessage, [
                'matricule' => $matricule,
                'level_id' => $this->deliberation->level_id,
                'year_academic_id' => $this->deliberation->year_academic_id,
            ]);

            throw new \RuntimeException($errorMessage);
        }

        $filename = $this->generatePdf($studentData, $courses, $summary, $eligible, $paidAcademic, $paidLabo, $enrollment);

        $result = $this->saveResult($student->id, $filename, $eligible, $paidAcademic, $paidLabo, $enrollment);

        Log::info("Relevé de cotes généré pour l'étudiant {$matricule}", [
            'student_id' => $student->id,
            'courses_count' => count($courses),
            'filename' => $filename,
        ]);

        $this->notifyStudent($student, $result);
    }

    protected function extractStudentData(Collection $rows): ?array
    {
        foreach ($rows as $i => $row) {
            $firstCell = strtoupper(trim($row[0] ?? ''));

            if ($firstCell === 'NOM' && isset($rows[$i + 1])) {
                $dataRow = $rows[$i + 1];

                return [
                    'nom'       => trim($dataRow[0] ?? ''),
                    'postnom'   => trim($dataRow[1] ?? ''),
                    'matricule' => trim($dataRow[2] ?? ''),
                    'genre'     => trim($dataRow[3] ?? ''),
                    'mention'   => trim($dataRow[4] ?? ''),
                    'eligible'  => trim($dataRow[5] ?? ''),
                ];
            }
        }

        return null;
    }

    protected function extractCourses(Collection $rows): array
    {
        $courses = [];
        $parsingCourses = false;

        foreach ($rows as $row) {
            $firstCell = strtoupper(trim($row[0] ?? ''));

            if ($firstCell === 'NR') {
                $parsingCourses = true;
                continue;
            }

            if ($parsingCourses) {
                if (!is_numeric($row[0] ?? '')) {
                    break;
                }

                $courses[] = [
                    'numero'   => $row[0] ?? null,
                    'intitule' => $row[1] ?? null,
                    'hrs_thtp' => $row[2] ?? null,
                    'note_an'  => $row[3] ?? null,
                    'note_ex'  => $row[4] ?? null,
                    'moyenne'  => $row[5] ?? null,
                ];
            }
        }

        return $courses;
    }

    protected function extractSummary(Collection $rows): array
    {
        $found = false;
        foreach ($rows as $row) {
            $firstCell = strtoupper(trim($row[0] ?? ''));
            if ($found) {
                // On est sur la ligne juste après "POURCENTAGE"
                return [
                    'pourcentage'      => $row[0] ?? null,
                    'credits_cap'         => $row[1] ?? null,
                    'status'         => $row[2] ?? null,
                    'frais_academique' => $row[3] ?? null,
                    'frais_labo'       => $row[4] ?? null,
                    'enrollment'       => $row[5] ?? null,
                ];
            }
            if ($firstCell === 'POURCENTAGE') {
                $found = true;
            }
        }
        return [];
    }
    protected function findStudent(string $matricule): ?Student
    {
        return Student::with('actualLevel')
            ->where('registration_token', $matricule)
            ->whereHas('actualLevel', function ($query) {
                $query->where('level_id', $this->deliberation->level_id)
                      ->where('year_academic_id', $this->deliberation->year_academic_id);
            })
            ->first();
    }

    protected function generatePdf(
        array $studentData,
        array $courses,
        array $summary,
        bool $eligible,
        bool $paidAcademic,
        bool $paidLabo,
        bool $enrollment
    ): string {
        $pdf = Pdf::loadView('pdf.student', [
            'infos'            => $studentData,
            'courses'          => $courses,
            'summary'          => $summary,
            'deliberation'     => $this->deliberation,
            'is_eligible'      => $eligible,
            'is_paid_academic' => $paidAcademic,
            'is_paid_labo'     => $paidLabo,
            'enrollment'       => $enrollment,
        ]);

        $filename = 'results/' . $studentData['matricule'] . '-' . Str::random(20) . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    protected function saveResult(
        int $studentId,
        string $filename,
        bool $eligible,
        bool $paidAcademic,
        bool $paidLabo,
        bool $enrollment
    ): Result {
        $attributes = [
            'deliberation_id' => $this->deliberation->id,
            'student_id' => $studentId,
        ];

        // On récupère l'ancien résultat s'il existe
        $existingResult = Result::where($attributes)->first();

        $values = [
            'file'               => $filename,
            'is_eligible'        => $eligible,
            'is_paid_academic'   => $paidAcademic,
            'is_paid_labo'       => $paidLabo,
            'is_paid_enrollment' => $enrollment,
        ];

        // Met à jour ou crée
        $result = Result::updateOrCreate($attributes, $values);

        // Si un ancien fichier existait et qu'il est différent du nouveau, on le supprime
        if ($existingResult && $existingResult->file !== $filename) {
            app(PublicFileUpload::class)->delete($existingResult->file);
        }

        return $result;
    }


    protected function notifyStudent(Student $student, Result $result): void
    {
        try {
            $student->user->notify(new ResultAvailable($result));
            Log::info("Notification envoyée à l'étudiant {$student->registration_token}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification à l'étudiant {$student->registration_token}: {$e->getMessage()}");
        }
    }
}
