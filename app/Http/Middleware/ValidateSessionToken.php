<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class ValidateSessionToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user) {

            $sessionId = session()->getId();
            
            $sessionToken = session('session_token');

            $cachedToken = Cache::get("user_session_{$user->id}_{$sessionId}");
    
            // If session token is missing or invalid, log out the user
            if (!$cachedToken || $cachedToken !== $sessionToken) {
                Auth::logout();
                return redirect()->route('login')->withErrors('Session expired. Please log in again.');
            }
        }
        return $next($request);
    }
}
