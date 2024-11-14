<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Redirects unauthenticated users.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Log when redirecting for debugging purposes
        Log::info('Unauthenticated user redirecting to login.');

        return $request->expectsJson() ? null : route('login');
    }
}
