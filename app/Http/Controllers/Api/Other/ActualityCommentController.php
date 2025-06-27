<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualityCommentRequest;
use App\Models\Actuality;
use App\Models\Comment;

class ActualityCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function store(ActualityCommentRequest $request, string $id)
    {
        $user = $request->user();

        $actuality = Actuality::findOrFail($id);

        $comment = $actuality->comments()->create([
            ...$request->validated(),
            'user_id' => $user->id
        ]);

        return response()->json([
            'state' => $comment !== null
        ]);
    }

     public function lock(string $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->update(['is_lock' => !$comment->is_lock]);

        return response()->json([
            'state' => $comment
        ]);
    }
}
