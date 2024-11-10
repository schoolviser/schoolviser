<?php

namespace App\Observers;

use App\Cache\AccountingPeriodCacheManager;

use App\Models\Accounting\AccountingPeriod;

class AccountingPeriodObserver
{
    protected $accountingPeriodCacheManager;

    public function __construct(AccountingPeriodCacheManager $accountingPeriodCacheManager)
    {
        $this->accountingPeriodCacheManager = $accountingPeriodCacheManager;
    }
    /**
     * Handle the accounting period "created" event.
     *
     * @param  \App\Models\Accounting\AccountingPeriod  $accountingPeriod
     * @return void
     */
    public function created(AccountingPeriod $accountingPeriod)
    {
        $this->accountingPeriodCacheManager->clearPeriodsFromCache();
    }

    /**
     * Handle the accounting period "updated" event.
     *
     * @param  \App\Models\Accounting\AccountingPeriod  $accountingPeriod
     * @return void
     */
    public function updated(AccountingPeriod $accountingPeriod)
    {
        //Clear current period from cache
        ($accountingPeriod->id == period()->id) ? $this->accountingPeriodCacheManager->clearCurrentPeriodFromCache() : $this->accountingPeriodCacheManager->clearAll();
    }

    /**
     * Handle the accounting period "deleted" event.
     *
     * @param  \App\Models\Accounting\AccountingPeriod  $accountingPeriod
     * @return void
     */
    public function deleted(AccountingPeriod $accountingPeriod)
    {
        //Clear current period from cache
        $this->accountingPeriodCacheManager->clearCurrentPeriodFromCache();
    }

    /**
     * Handle the accounting period "restored" event.
     *
     * @param  \App\Models\Accounting\AccountingPeriod  $accountingPeriod
     * @return void
     */
    public function restored(AccountingPeriod $accountingPeriod)
    {
        //Clear current period from cache
        $this->accountingPeriodCacheManager->clearCurrentPeriodFromCache();
    }

    /**
     * Handle the accounting period "force deleted" event.
     *
     * @param  \App\Models\Accounting\AccountingPeriod  $accountingPeriod
     * @return void
     */
    public function forceDeleted(AccountingPeriod $accountingPeriod)
    {
        //Clear current period from cache
        $this->accountingPeriodCacheManager->clearCurrentPeriodFromCache();
    }
}
