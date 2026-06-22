<?php

namespace Modules\Schoolviser\Http\Middleware;

use Closure;

class TermMiddleware
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
        $term = term();
        
        if($term){
            return $next($request);
        }
        return abort(403, 'No active term found. Please set the current term before proceeding.');
    }
    
}
