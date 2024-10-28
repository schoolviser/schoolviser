<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard 
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $userType = Auth::guard()->user()->user_type;
            if ($userType == 'Modules\User\Entities\Master') {
                //redirect basing on the usertype
                return redirect(RouteServiceProvider::HOME);
            }
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
