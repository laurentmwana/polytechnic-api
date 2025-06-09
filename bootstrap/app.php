<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckRoleAdmin;
use App\Http\Middleware\CheckRoleStudent;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\CheckRoleDisableAccount;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: [
            __DIR__ . '/../routes/admin.php',
            __DIR__ . '/../routes/api.php',
            __DIR__ . '/../routes/auth.php',
            __DIR__ . '/../routes/other.php',
            __DIR__ . '/../routes/student.php',
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->append([
            ForceJsonResponse::class
        ]);

        $middleware->alias([
            'admin' => CheckRoleAdmin::class,
            'student' => CheckRoleStudent::class,
            'student-state' => CheckRoleDisableAccount::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            $url = $request->url();

            return response()->json([
                'message' => "La route {$url} n'existe pas"
            ], 404);
        });

        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            return response()->json([
                'message' => "Trop de requêtes. Veuillez réessayer plus tard."
            ], 429);
        });

        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            return response()->json(['message' => "unauthorized"], 401);
        });
    })->create();
