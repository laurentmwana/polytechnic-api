<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Student;
use App\Models\Result;
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

        $student = Student::where('user_id', '=', $user->id)
            ->first();

        if (!$student) {
            return response()->json([
                'data' => []
            ]);
        }

        $results = $student->results()->paginate();

        return ResultCollectionResource::collection($results);
    }

    public function download(Request $request, string $id)
    {
        $user = $request->user();

        $student = Student::where('user_id', '=', $user->id)
            ->first();

        if (!$student) {
            return response()->json([
                'data' => []
            ],404);
        }

        $result = $student->results()->findOrFail($id);

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
