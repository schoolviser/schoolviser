<?php

namespace App\Observers;

use App\Entities\Subject;
 
use App\Cache\CacheKeys\SubjectCacheKeys;

class SubjectObserver
{
    /**
     * Handle the Subject "created" event.
     */
    public function created(Subject $model): void
    {
        SubjectCacheKeys::clearCache();
        SubjectCacheKeys::clearCacheUpToLastPage(15,100, 'subjects');
    }

    /**
     * Handle the Subject "updated" event.
     */
    public function updated(Subject $model): void
    {
        SubjectCacheKeys::clearCache();
        SubjectCacheKeys::clearCacheUpToLastPage(15,100, 'subjects');

    }

    /**
     * Handle the Subject "deleted" event.
     */
    public function deleted(Subject $model): void
    {
        SubjectCacheKeys::clearCache();
        SubjectCacheKeys::clearCacheUpToLastPage(15,100, 'subjects');

    }

    /**
     * Handle the Subject "restored" event.
     */
    public function restored(Subject $model): void
    {
        SubjectCacheKeys::clearCache();
        SubjectCacheKeys::clearCacheUpToLastPage(15,100, 'subjects');

    }

    /**
     * Handle the Subject "force deleted" event.
     */
    public function forceDeleted(Subject $model): void
    {
        SubjectCacheKeys::clearCache();
        SubjectCacheKeys::clearCacheUpToLastPage(15,100, 'subjects');

    }
}
