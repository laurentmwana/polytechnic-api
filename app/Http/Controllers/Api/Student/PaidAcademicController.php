<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Paid\PaidAcademicCollectionResource;
use App\Http\Resources\Paid\PaidAcademicItemResource;
use App\Models\PaidAcademic;
use Illuminate\Http\Request;

class PaidAcademicController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $paids = PaidAcademic::with(['feesAcademic'])
            ->where('student_id', '=', $user->student->id)
            ->orderByDesc('updated_at')->paginate();

        return PaidAcademicCollectionResource::collection($paids);
    }


    public function show(string $id, Request $request)
    {
        $user = $request->user();

        $paid = PaidAcademic::where('student_id', '=', $user->student->id)
            ->findOrFail($id);

        return new PaidAcademicItemResource($paid);
    }
}
