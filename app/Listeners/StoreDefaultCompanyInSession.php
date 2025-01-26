<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;

class StoreDefaultCompanyInSession
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        $user = $event->user;

        // Fetch the default company for the user
        $defaultCompany = $user->companies()->wherePivot('is_default', true)->first();

        // Store the default company ID in the session
        session(['default_company_id' => $defaultCompany ? $defaultCompany->id : null]);
    }
}
