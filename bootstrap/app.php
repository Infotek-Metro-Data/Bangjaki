<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        
        // Configure where to redirect guests when they try to access protected routes
        $middleware->redirectGuestsTo('/login');
        
        // Configure where to redirect authenticated users when they try to access guest-only routes
        $middleware->redirectUsersTo(function ($request) {
            $user = $request->user();
            if (!$user) return '/login';
            
            return match($user->peran ?? null) {
                'admin' => '/admin/dashboard',
                'petugas' => '/petugas',
                default => '/login',
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

