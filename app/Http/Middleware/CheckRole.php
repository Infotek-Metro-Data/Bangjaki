<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->peran ?? null;
        
        if ($userRole !== $role) {
            return match($userRole) {
                'admin' => redirect()->route('admin.dashboard'),
                'petugas' => redirect()->route('petugas.home'),
                default => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}

