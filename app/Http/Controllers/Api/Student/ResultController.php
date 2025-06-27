<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Student;
use App\Models\Result;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Result\ResultCollectionResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class ResultController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $builder = Student::where('user_id', '=', $user->id)
            ->first();

        if (!$builder) {
            return response()->json([
                'data' => []
            ]);
        }


         $search = $request->query->get('search');

        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, SEARCH_FIELDS_RESULT);
                $query->orWhereHas('deliberation', function ($q) use ($search) {
                    SearchData::handle($q, $search, SEARCH_FIELDS_DELIBE);
                });
            });
        }

        $results = $builder->paginate();

        return ResultCollectionResource::collection($results);
    }

    public function download(Request $request, string $id)
    {
        $user = $request->user();

        $student = Student::where('user_id', '=', $user->id)
            ->first();

        if (!$student) {
            return response()->json([
                'message' => "ce compte n'est pas associé à un étudiant (:"
            ],404);
        }

        $result = $student->results()->findOrFail($id);

        if ($result->is_paid_labo && !$result->is_paid_academic) {
            throw new \Exception("Vous n'êtes pas en ordre vec le frais académique");
        }

        elseif (!$result->is_paid_labo && $result->is_paid_academic) {
            throw new \Exception("Vous n'êtes pas en ordre vec le frais de labo");
        }

        return $this->downloadFile($result);

    }
    private function downloadFile(Result $result): BinaryFileResponse
    {
        if (!Storage::disk('public')->exists($result->file)) {
            return response()->json([
                'message' => "Le fichier demandé est introuvable"
            ], 404);
        }

        return response()->download(
            Storage::disk('public')->path($result->file),
            basename($result->file),
            ['Content-Type' => 'application/pdf']
        );
    }
}
