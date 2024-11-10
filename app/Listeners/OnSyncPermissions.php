<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Delgont\Auth\Models\Role;

class OnSyncPermissions
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $role = Role::firstOrCreate(['name' => 'master'], ['name' => 'master']);
        $role->syncPermissions($event->permissions);
    }
}
