<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Models\Actuality;
use App\Models\Like;
use Illuminate\Http\Request;

class ActualityLikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $user = $request->user();

        $actuality = Actuality::findOrFail($id);

        $like = Like::where('user_id', '=', $user->id)
            ->where('id', '=', $actuality->id)
            ->first();

        $like
            ? $like->update(['is_like' => !$like->is_like])
            : $actuality->likes()->create(['user_id' => $user->id]);

        return response()->json([
            'state' => true
        ]);
    }
}
