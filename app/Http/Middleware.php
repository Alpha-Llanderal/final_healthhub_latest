<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        // Log unauthorized access attempts
        if (!$request->expectsJson()) {
            Log::warning('Unauthorized access attempt', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method()
            ]);
        }

        // Differentiate between API and web routes
        if ($request->is('api/*')) {
            // For API routes, return null to send a 401 Unauthorized response
            return null;
        }

        // For web routes, redirect to login
        return route('login');
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        // Additional custom handling
        if ($request->expectsJson()) {
            // For API requests, return a JSON response
            return response()->json([
                'message' => 'Unauthenticated.',
                'errors' => 'Authentication is required to access this resource.'
            ], 401);
        }

        // Default Laravel behavior for web routes
        parent::unauthenticated($request, $guards);
    }
}