<?php

namespace Modules\Schoolviser\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecondarySchoolMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
