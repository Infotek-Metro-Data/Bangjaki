<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($role === 'pelanggan') {
            if (!Auth::guard('pelanggan')->check()) {
                return redirect()->route('login');
            }
            return $next($request);
        }

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
