<?php
namespace App\Imports;

use App\Models\Student;
use App\Models\Deliberation;
use App\Models\Result;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudentSheetImport implements ToCollection
{
    public function __construct(private Deliberation $deliberation) {}

    public function collection(Collection $rows)
    {
        $studentData = [];
        $ues = [];
        $summary = [];
        $matricule = null;
        $eligible = null;
        $paid = null;

        $parsingUes = false;
        $parsingSummary = false;

        foreach ($rows as $i => $row) {
            $firstCell = strtoupper(trim($row[0] ?? ''));

            // Ligne des infos
            if ($firstCell === 'NOMS') {
                $studentData = [
                    'noms'      => $rows[$i + 1][0] ?? null,
                    'mention'   => $rows[$i + 1][1] ?? null,
                    'matricule' => $rows[$i + 1][2] ?? null,
                    'eligible'  => $rows[$i + 1][3] ?? null,
                    'paid'      => $rows[$i + 1][4] ?? null,
                ];
                $matricule = $studentData['matricule'];
                $eligible = strtoupper(trim($studentData['eligible'])) === 'OUI';
                $paid = $studentData['paid'] ?? null;
                continue;
            }

            // Début des UEs
            if ($firstCell === 'Labo / Académique' || $firstCell === 'CODE UE') {
                $parsingUes = true;
                continue;
            }

            // Début du résumé
            if ($firstCell === 'MOYENNE CATEGORIE A') {
                $parsingUes = false;
                $parsingSummary = true;
                continue;
            }

            // Résumé : ligne suivante après l'entête
            if ($parsingSummary && !empty($row[0]) && is_numeric($row[0])) {
                $summary = [
                    'moyenne_categorie_a' => $row[0] ?? null,
                    'moyenne_categorie_b' => $row[1] ?? null,
                    'moyenne_semestre'    => $row[2] ?? null,
                    'credits_capitaliser' => $row[3] ?? null,
                    'decision'            => $row[4] ?? null,
                ];
                $parsingSummary = false;
                continue;
            }

            // UEs
            if ($parsingUes && !empty($row[0]) && strpos($row[0], 'UE') === 0) {
                $ues[] = [
                    'code_ue'   => $row[0] ?? null,
                    'intitule'  => $row[1] ?? null,
                    'categorie' => $row[2] ?? null,
                    'credit'    => $row[3] ?? null,
                    'moyenne'   => $row[4] ?? null,
                ];
                continue;
            }
        }

        if (!$matricule) {
            \Log::warning('Matricule manquant.', [$rows->toArray()]);
            return;
        }

        $student = Student::where('registration_token', $matricule)->first();
        if (!$student) {
            \Log::warning("Étudiant introuvable pour matricule : $matricule");
            return;
        }

        // Gestion des paiements labo/académique
        $isPaidLabo = false;
        $isPaidAcademic = false;
        if ($paid && str_contains($paid, '/')) {
            [$paidLabo, $paidAcademic] = array_map('trim', explode('/', $paid));
            $isPaidLabo = strtoupper($paidLabo) === 'OUI';
            $isPaidAcademic = strtoupper($paidAcademic) === 'OUI';
        }

        // Générer PDF
        $pdf = Pdf::loadView('pdf.student', [
            'infos'            => $studentData,
            'ues'              => $ues,
            'summary'          => $summary,
            'deliberation'     => $this->deliberation,
            'is_eligible'      => $eligible,
            'is_paid_labo'     => $isPaidLabo,
            'is_paid_academic' => $isPaidAcademic,
        ]);

        $fileId = $matricule . '-' . Str::random(20);
        $filename = 'results/' . $fileId . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        Result::create([
            'file'              => $filename,
            'student_id'        => $student->id,
            'deliberation_id'   => $this->deliberation->id,
            'is_eligible'       => $eligible ?? false,
            'is_paid_labo'      => $isPaidLabo,
            'is_paid_academic'  => $isPaidAcademic,
        ]);

        \Log::info("Résultat enregistré pour $matricule");
    }
}
