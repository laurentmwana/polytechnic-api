<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\PaidLaboratory;
use App\Http\Controllers\Controller;
use App\Http\Resources\Paid\PaidLaboCollectionResource;
use App\Http\Resources\Paid\PaidLaboItemResource;

class AdminPaidLaboratoryController extends Controller
{

    public function index()
    {
        $paids = PaidLaboratory::with(['student', 'feesAcademic'])
            ->orderByDesc('updated_at')
            ->paginate();

        return PaidLaboCollectionResource::collection($paids);
    }

    public function changeStatus(string $id)
    {

        $academic = PaidLaboratory::findOrFail($id);

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
        $paid = PaidLaboratory::findOrFail($id);

        return new PaidLaboItemResource($paid);
    }
}
