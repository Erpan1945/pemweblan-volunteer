<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // admin
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Penanganan untuk token yang TIDAK VALID
        $exceptions->render(function (TokenInvalidException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Token is invalid'], 401);
            }
        });

        // Penanganan untuk token yang SUDAH KEDALUWARSA
        $exceptions->render(function (TokenExpiredException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Token has expired'], 401);
            }
        });
        
        // Penanganan untuk user yang BELUM LOGIN (tidak ada token)
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
        });
    })->create();
