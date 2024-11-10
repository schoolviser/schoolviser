<?php

namespace App\Observers;

use App\Entities\Term;
 
use App\Cache\CacheKeys\TermCacheKeys;

class TermObserver
{
    /**
     * Handle the Term "created" event.
     */
    public function created(Term $model): void
    {
        TermCacheKeys::clearCache();
        TermCacheKeys::clearCacheUpToLastPage(15,100, 'terms');
    }

    /**
     * Handle the Term "updated" event.
     */
    public function updated(Term $model): void
    {
        TermCacheKeys::clearCache();
        TermCacheKeys::clearCacheUpToLastPage(15,100, 'terms');

    }

    /**
     * Handle the Term "deleted" event.
     */
    public function deleted(Term $model): void
    {
        TermCacheKeys::clearCache();
        TermCacheKeys::clearCacheUpToLastPage(15,100, 'terms');

    }

    /**
     * Handle the Term "restored" event.
     */
    public function restored(Term $model): void
    {
        TermCacheKeys::clearCache();
        TermCacheKeys::clearCacheUpToLastPage(15,100, 'terms');

    }

    /**
     * Handle the Term "force deleted" event.
     */
    public function forceDeleted(Term $model): void
    {
        TermCacheKeys::clearCache();
        TermCacheKeys::clearCacheUpToLastPage(15,100, 'terms');

    }
}
