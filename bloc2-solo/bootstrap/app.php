<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // En-têtes de sécurité appliqués à toutes les réponses web.
        $middleware->web(append: [
            SecurityHeaders::class,
        ]);

        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'role' => RoleMiddleware::class,
        ]);
        $middleware->redirectUsersTo('/'); // ← redirige vers home après login
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
