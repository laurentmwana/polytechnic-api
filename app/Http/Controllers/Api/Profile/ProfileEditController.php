<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Resources\Auth\UserLoginResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ProfileEditController extends Controller
{
    public function __invoke(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $token = Auth::refresh();

        $user->token = $token;

        return new UserLoginResource($user);
    }
}
