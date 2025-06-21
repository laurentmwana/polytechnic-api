<?php

namespace App\Http\Controllers\Api\Profile;

use App\Notifications\UpdatePasswordUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilePasswordController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();

        $state = $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        if ($state) {
            $user->notify(new UpdatePasswordUser());
        }

        return response()->json(['state' => $state]);
    }
}
