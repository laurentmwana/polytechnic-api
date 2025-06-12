<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Http\Resources\Folder\FolderCollectionResource;


class FolderController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $student = Student::where('user_id', '=', $user->id)
            ->first();

        if (!$student) {
            return response()->json([
                'data' => []
            ]);
        }

        return new FolderCollectionResource($student);
    }
}
