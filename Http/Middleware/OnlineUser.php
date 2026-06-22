<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Cache;
use Modules\User\Entities\User;

class OnlineUser
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
        if(Auth::check()){
            $expireAt = now()->addMinutes(2);
            //Check if online
            if (!Cache::get('user-is-online-'.Auth::id())) {
                Cache::put('user-is-online-'.Auth::id(), true, $expireAt);
                User::whereId(Auth::id())->update(['last_seen_at' => now()]);
            }
        }
        return $next($request);
    }
}
