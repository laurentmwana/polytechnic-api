<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\Auth\UserLoginResource;
use App\Enums\RoleUserEnum;

class AuthenticatedSessionController extends Controller
{

    public function login(LoginRequest $request): UserLoginResource|JsonResponse
    {
        if (! $token = Auth::attempt($request->validated())) {
            return response()->json(['message' => 'Adresse e-mail ou mot de passe incorrect'], 401);
        }

        $user = Auth::user();

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Votre compte est désactivé, vous devez confirmer votre adresse e-mail pour continuer'
            ], 401);
        }

        $rolesToCheck = [RoleUserEnum::STUDENT->value, RoleUserEnum::DISABLE->value];

        if (empty(array_diff($rolesToCheck, $user->roles))) {
            return response()->json([
                'message' => 'Votre compte a été bloqué par l\'administrateur'
            ], 401);
        }


        return $this->getResponseUser($user, $token);
    }


    public function refresh(Request $request): UserLoginResource|JsonResponse
    {
        try {
            $token = Auth::refresh();
        } catch (\Exception $e) {
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
