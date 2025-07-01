<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Student;
use App\Models\Result;
use App\Services\SearchData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Result\ResultCollectionResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return response()->json(['data' => []]);
        }

        $builder = $student->results()->with('deliberation');

        if ($search = $request->query('search')) {
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

    public function download(Request $request, string $id): BinaryFileResponse|JsonResponse
    {
        $user = $request->user();

        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return response()->json([
                'message' => "Ce compte n'est pas associé à un étudiant.",
            ], 404);
        }

        $result = $student->results()->findOrFail($id);

        if (!$result->is_paid_academic) {
            return response()->json([
                'message' => "Vous n'êtes pas en ordre avec le frais académique.",
            ], 403);
        }

        if (!$result->is_paid_labo) {
            return response()->json([
                'message' => "Vous n'êtes pas en ordre avec le frais de laboratoire.",
            ], 403);
        }

        if (!$result->is_paid_enrollment) {
            return response()->json([
                'message' => "Vous n'êtes pas en ordre avec le frais d'enrolement.",
            ], 403);
        }

        return $this->downloadFile($result);
    }

    private function downloadFile(Result $result): BinaryFileResponse|JsonResponse
    {
        if (!Storage::disk('public')->exists($result->file)) {
            return response()->json([
                'message' => "Le fichier demandé est introuvable.",
            ], 404);
        }

        return response()->download(
            Storage::disk('public')->path($result->file),
            basename($result->file),
            ['Content-Type' => 'application/pdf']
        );
    }
}
