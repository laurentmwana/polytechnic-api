<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\RoleUserEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !in_array(RoleUserEnum::ADMIN->value, $user->roles)) {
            return response()->json(['message' => 'Accès refusé. Rôle administrateur requis.'], 403);
        }

        return $next($request);
    }
}
