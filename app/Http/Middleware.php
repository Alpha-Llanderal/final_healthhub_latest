<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Check if user is active
            if (!Auth::user()->is_active) {
                Auth::logout();
                
                Log::warning('Inactive user attempted to access protected route', [
                    'user_id' => $request->user()->id,
                    'email' => $request->user()->email,
                    'ip' => $request->ip()
                ]);

                return redirect()->route('login')
                    ->with('error', 'Your account has been deactivated. Please contact support.');
            }

            // Check for password reset or additional verification
            if (Auth::user()->must_reset_password) {
                return redirect()->route('password.reset');
            }
        }

        return $next($request);
    }
}