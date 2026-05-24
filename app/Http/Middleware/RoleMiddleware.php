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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu');
        }

        $user = auth()->user();

        // Check if user role is in allowed roles
        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return $next($request);
    }
}
