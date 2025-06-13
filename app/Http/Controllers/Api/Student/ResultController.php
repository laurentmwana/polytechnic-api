<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Result\ResultCollectionResource;


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
        

        return new ResultCollectionResource($results);
    }

    public function download(Request $request, string $id)
    {

    }
}
