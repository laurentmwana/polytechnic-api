<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\Auth\UserLoginResource;

class AuthenticatedSessionController extends Controller
{
    public function login(LoginRequest $request): UserLoginResource | JsonResponse
    {
        if (! $token = Auth::attempt($request->validated())) {
            return response()->json(['message' => 'Adresse e-mail ou mot de passe incorrect '], 401);
        }

        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Votre compte est désactivé, vous devez confirmé votre adresse e-mail pour continuer'], 401);
        }


        return $this->getResponseUser($request->user(), $token);
    }

    public function refresh(Request $request): UserLoginResource | JsonResponse
    {
        if (! $token = Auth::refresh()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $this->getResponseUser($request->user(), $token);
    }

    private function getResponseUser(User $user, string $token): UserLoginResource
    {
        $user->token = $token;
        return new UserLoginResource($user);
    }
}
