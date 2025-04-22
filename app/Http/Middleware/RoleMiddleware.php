<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        // Split role parameter by pipe and convert to array
        $roles = explode('|', $role);

        // Check if user has any of the required roles
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access');
    }
}
