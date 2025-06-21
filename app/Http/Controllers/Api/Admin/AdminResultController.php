<?php

namespace App\Http\Controllers\Api\Admin;

use App\Jobs\StudentResultsPublisherJob;
use App\Models\Result;
use App\Models\Deliberation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Services\Upload\FileUploadAction;
use App\Http\Resources\Result\ResultItemResource;
use App\Http\Resources\Result\ResultCollectionResource;

class AdminResultController extends Controller
{
    private const PATH_PDF = 'results';
    private const TEMP_DIR = 'app/temp';

    public function __construct(private FileUploadAction $upload) {}

    public function index(Request $request)
    {
        $results = Result::paginate();

        return ResultCollectionResource::collection($results);
    }

    public function store(ResultRequest $request)
    {
        $deliberation = Deliberation::with(['level', 'yearAcademic'])
            ->findOrFail($request->validated('deliberation_id'));

        $filePath = $this->storeTempFile($request->file('file'));

        StudentResultsPublisherJob::dispatch(
            $filePath,
            $deliberation,
            $request->user()
        );

        return response()->json(['state' => true]);
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

        return response()->json(['state' => $state]);
    }

    public function destroy(string $id)
    {
        $result = Result::findOrFail($id);

        $state = $result->delete();

        return response()->json(['state' => $state]);
    }

    private function storeTempFile(\Illuminate\Http\UploadedFile $file): string
    {
        $tempPath = storage_path(self::TEMP_DIR);

        if (!is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $filename = 'import_' . time() . '.xlsx';
        $filePath = $tempPath . '/' . $filename;

        $file->move($tempPath, $filename);

        return $filePath;
    }
}
