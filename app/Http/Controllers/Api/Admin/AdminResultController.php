<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Services\Upload\FileUploadAction;
use App\Http\Resources\Result\ResultItemResource;
use App\Http\Resources\Result\ResultCollectionResource;

class AdminResultController extends Controller
{
    private const PATH_PDF = "results";

    public function __construct(private FileUploadAction $upload) {}

    public function index(Request $request)
    {
        $results = Result::paginate();

        return ResultCollectionResource::collection($results);
    }

    public function store(ResultRequest $request)
    {
        $filePdf = $this->upload->handle(
            self::PATH_PDF,
            $request->validated('file'),
        );

        $result = Result::create([
            ...$request->validated(),
            'file' => $filePdf
        ]);

        return response()->json([
            'state' => $result !== null
        ]);
    }

    public function show(string $id)
    {
        $result = Result::with(['student', 'deliberation'])
            ->findOrFail($id);

        return new ResultItemResource($result);
    }


    public function update(ResultRequest $request, string $id)
    {
        $result = Result::findOrFail($id);

        $filePdf = $this->upload->handle(
            self::PATH_PDF,
            $request->validated('file'),
            $result->file
        );

        $state = $result->update([
            ...$request->validated(),
            'file' => $filePdf,
        ]);

        return response()->json([
            'state' => $state
        ]);
    }

    public function destroy(string $id)
    {
        $result = Result::findOrFail($id);

        $state = $result->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
