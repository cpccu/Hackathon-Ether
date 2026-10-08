<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. Super Admin can access EVERYTHING (Admin, CR, and User dashboards)
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // 2. Exact role match check
        if ($user->role === $role) {
            return $next($request);
        }

        // 3. Allow CR to also access the normal user dashboard if needed
        if ($user->role === 'cr' && $role === 'user') {
            return $next($request);
        }

        // 4. Smooth Redirection for unauthorized access attempts
        // If a normal user or CR tries to access a restricted area, send them back to their proper dashboard smoothly.
        if ($user->role === 'cr') {
            return redirect()->route('cr.dashboard')->with('error', 'Unauthorized access. Redirected to your dashboard.');
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access. Redirected to your dashboard.');
    }
}