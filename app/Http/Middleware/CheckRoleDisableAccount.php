<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\RoleUserEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleDisableAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !in_array([
            RoleUserEnum::STUDENT->value,
            RoleUserEnum::DISABLE->value
        ], $user->roles)) {
            return response()->json(['message' => 'Accès refusé. Ce compte étudiant a été désactivé'], 403);
        }

        return $next($request);
    }
}
