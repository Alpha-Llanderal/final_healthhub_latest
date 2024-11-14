<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Log for debugging purposes
                Log::info("RedirectIfAuthenticated: User is already authenticated, redirecting to dashboard.");

                // Redirect authenticated users to the dashboard
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
