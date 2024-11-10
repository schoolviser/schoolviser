<?php

namespace App\Observers;

use App\Entities\TermlyExpenseSummary;
 
use App\Cache\CacheKeys\TermlyExpenseSummaryCacheKeys;

class TermlyExpenseSummaryObserver
{
    /**
     * Handle the TermlyExpenseSummary "created" event.
     */
    public function created(TermlyExpenseSummary $model): void
    {
        TermlyExpenseSummaryCacheKeys::clearCache();
        TermlyExpenseSummaryCacheKeys::clearCacheUpToLastPage(15,100, 'termlyexpensesummaries');
    }

    /**
     * Handle the TermlyExpenseSummary "updated" event.
     */
    public function updated(TermlyExpenseSummary $model): void
    {
        TermlyExpenseSummaryCacheKeys::clearCache();
        TermlyExpenseSummaryCacheKeys::clearCacheUpToLastPage(15,100, 'termlyexpensesummaries');

    }

    /**
     * Handle the TermlyExpenseSummary "deleted" event.
     */
    public function deleted(TermlyExpenseSummary $model): void
    {
        TermlyExpenseSummaryCacheKeys::clearCache();
        TermlyExpenseSummaryCacheKeys::clearCacheUpToLastPage(15,100, 'termlyexpensesummaries');

    }

    /**
     * Handle the TermlyExpenseSummary "restored" event.
     */
    public function restored(TermlyExpenseSummary $model): void
    {
        TermlyExpenseSummaryCacheKeys::clearCache();
        TermlyExpenseSummaryCacheKeys::clearCacheUpToLastPage(15,100, 'termlyexpensesummaries');

    }

    /**
     * Handle the TermlyExpenseSummary "force deleted" event.
     */
    public function forceDeleted(TermlyExpenseSummary $model): void
    {
        TermlyExpenseSummaryCacheKeys::clearCache();
        TermlyExpenseSummaryCacheKeys::clearCacheUpToLastPage(15,100, 'termlyexpensesummaries');

    }
}
