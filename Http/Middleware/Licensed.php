<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class Licensed
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
        if(option('license')){
            if( option('last_license_validation_date') && Carbon::parse(option('last_license_validation_date'))->diffInDays(Carbon::today()) < 30 ){
                return $next($request);
            }else{
                //validate the licence and update the last validation date
            }
        }
        return redirect()->route('licensing');

    }
}
