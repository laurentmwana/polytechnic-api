<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Paid\PaidLaboCollectionResource;
use App\Http\Resources\Paid\PaidLaboItemResource;
use App\Models\PaidLaboratory;
use Illuminate\Http\Request;

class PaidLaboratoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $paids = PaidLaboratory::with(['feesLaboratory'])
            ->where('student_id', '=', $user->student->id)
            ->orderByDesc('updated_at')->paginate();

        return PaidLaboCollectionResource::collection($paids);
    }


    public function show(string $id, Request $request)
    {
        $user = $request->user();

        $paid = PaidLaboratory::where('student_id', '=', $user->student->id)
            ->findOrFail($id);

        return new PaidLaboItemResource($paid);
    }
}
