<?php

namespace App\Http\Controllers\Api\Admin;

use App\Imports\StudentResultsImport;
use App\Jobs\PublishedResultStudentJob;
use App\Models\Result;
use App\Models\Deliberation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Services\Upload\FileUploadAction;
use App\Http\Resources\Result\ResultItemResource;
use App\Http\Resources\Result\ResultCollectionResource;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $file = $request->file('file');

        $deliberation  = Deliberation::with(['level', 'yearAcademic'])
            ->findOrFail($request->validated('deliberation_id'));

        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $user = $request->user();

        $filename = 'import_' . time() . '.xlsx';
        $filePath = $tempDir . '/' . $filename;

    
        $file->move($tempDir, $filename);

        PublishedResultStudentJob::dispatch(
            $filePath,
            $deliberation,
            $user
        );


        return response()->json([
            'state' => true
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
