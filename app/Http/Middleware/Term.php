<?php

namespace App\Http\Middleware;

use Closure;

class Term
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
        return redirect()->route('init.set.term');
    }
    
}
