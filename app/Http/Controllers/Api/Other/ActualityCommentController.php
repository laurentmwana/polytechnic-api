<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualityCommentRequest;
use App\Models\Actuality;
use App\Models\Comment;
use App\Models\User;

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
            'message' => $request->validated('message'),
            'username' => $user instanceof User ? $user->name : $request->validated('username'),
            'user_id' => $user instanceof User  ? $user->id : null
        ]);

        return response()->json([
            'state' => $comment !== null
        ]);
    }
}
