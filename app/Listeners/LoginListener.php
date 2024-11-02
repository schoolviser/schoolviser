<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Auth\Events\Login;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

//Notifications
use Modules\User\Notifications\AccountAccessedFromDifferentIP;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //return;

        if ($event->user) {
            $user = $event->user;
            $ip = $this->request->ip();
            $userAgent = $this->request->userAgent();

            
            
            $known = $user->authentications()->whereIpAddress($ip)->whereUserAgent($userAgent)->whereLoginSuccessful(true)->first();

            //Notify the User for unknow IP
            if($ip !== $user->last_ip){
                $user->notify(new AccountAccessedFromDifferentIP($ip));
            }
            
            $newUser = Carbon::parse($user->{$user->getCreatedAtColumn()})->diffInMinutes(Carbon::now()) < 1;

            // Update the user's last_ip column with the current IP address
            $user->update([
                'last_ip' => $ip,
            ]);

            $log = $user->authentications()->create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'login_at' => now(),
                'login_successful' => true,
                'location' => null,
            ]);
            


        }
    }
}
