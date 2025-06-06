<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\PaidAcademic;
use App\Http\Controllers\Controller;
use App\Http\Resources\Paid\PaidAcademicCollectionResource;
use App\Http\Resources\Paid\PaidLaboItemResource;

class AdminPaidAcademicController extends Controller
{

    public function index()
    {
        $paids = PaidAcademic::with(['student', 'feesAcademic'])
            ->orderByDesc('updated_at')
            ->paginate();

        return PaidAcademicCollectionResource::collection($paids);
    }

    public function changeStatus(string $id)
    {

        $academic = PaidAcademic::findOrFail($id);

        $state = $academic->update([
            'is_paid' =>  !$academic->is_paid,
            'paid_at' => $academic->paid_at ? null : now()
        ]);

        return response()->json([
            'state' => $state
        ]);
    }

    public function show(string $id)
    {
        $paid = PaidAcademic::findOrFail($id);

        return new PaidLaboItemResource($paid);
    }
}
