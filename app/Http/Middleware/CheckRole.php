<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Use 'peran' column which is the actual column name in database
        $userRole = auth()->user()->peran ?? null;
        
        if ($userRole !== $role) {
            // Redirect to appropriate dashboard based on user's actual role
            return match($userRole) {
                'admin' => redirect()->route('admin.dashboard'),
                'petugas' => redirect()->route('petugas.home'),
                default => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}

