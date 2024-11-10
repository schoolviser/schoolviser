<?php

namespace App\Observers\Accounting;

use App\Models\Accounting\Coa\Revenue;

# Cache Managers
use App\Cache\CoaCacheManager;

class RevenueObserver
{
    /**
     * Handle the revenue "created" event.
     *
     * @param  \App\App\Models\Accounting\Coa\Revenue  $revenue
     * @return void
     */
    public function created(Revenue $revenue)
    {
        // Clear revenues from cache
        CoaCacheManager::clearRevenuesFromCache();
    }

    /**
     * Handle the revenue "updated" event.
     *
     * @param  \App\App\Models\Accounting\Coa\Revenue  $revenue
     * @return void
     */
    public function updated(Revenue $revenue)
    {
        CoaCacheManager::clearRevenuesFromCache();
        
    }

    /**
     * Handle the revenue "deleted" event.
     *
     * @param  \App\App\Models\Accounting\Coa\Revenue  $revenue
     * @return void
     */
    public function deleted(Revenue $revenue)
    {
        CoaCacheManager::clearRevenuesFromCache();
    }

    /**
     * Handle the revenue "restored" event.
     *
     * @param  \App\App\Models\Accounting\Coa\Revenue  $revenue
     * @return void
     */
    public function restored(Revenue $revenue)
    {
        CoaCacheManager::clearRevenuesFromCache();
    }

    /**
     * Handle the revenue "force deleted" event.
     *
     * @param  \App\App\Models\Accounting\Coa\Revenue  $revenue
     * @return void
     */
    public function forceDeleted(Revenue $revenue)
    {
        CoaCacheManager::clearRevenuesFromCache();
    }
}
