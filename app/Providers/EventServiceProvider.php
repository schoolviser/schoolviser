<?php

namespace App\Providers;

/**
 * Authentication events
 */
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;


use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use App\Listeners\LoginListener;
use App\Listeners\MarkAssetAsCheckedOut;
use App\Listeners\AssetCheckedIn;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            LoginListener::class
        ],
        \Illuminate\Auth\Events\Authenticated::class => [
            \App\Listeners\StoreDefaultCompanyInSession::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
