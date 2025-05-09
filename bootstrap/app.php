<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->map(\Illuminate\Auth\AuthenticationException::class, function ($exception) {
            $request = request(); // Get the current request
    
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
    
            // Redirect to /iniciar-sesion for non-JSON requests
            return new \Illuminate\Http\Exceptions\HttpResponseException(
                redirect('/iniciar-sesion')
            );
        });
    })->create();
