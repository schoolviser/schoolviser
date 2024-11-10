<?php

namespace App\Observers;

use App\Entities\Clazz;
 
use App\Cache\CacheKeys\ClazzCacheKeys;

class ClazzObserver
{
    /**
     * Handle the Clazz "created" event.
     */
    public function created(Clazz $model): void
    {
        ClazzCacheKeys::clearCache();
        ClazzCacheKeys::clearCacheUpToLastPage(15,100, 'clazzs');
    }

    /**
     * Handle the Clazz "updated" event.
     */
    public function updated(Clazz $model): void
    {
        ClazzCacheKeys::clearCache();
        ClazzCacheKeys::clearCacheUpToLastPage(15,100, 'clazzs');

    }

    /**
     * Handle the Clazz "deleted" event.
     */
    public function deleted(Clazz $model): void
    {
        ClazzCacheKeys::clearCache();
        ClazzCacheKeys::clearCacheUpToLastPage(15,100, 'clazzs');

    }

    /**
     * Handle the Clazz "restored" event.
     */
    public function restored(Clazz $model): void
    {
        ClazzCacheKeys::clearCache();
        ClazzCacheKeys::clearCacheUpToLastPage(15,100, 'clazzs');

    }

    /**
     * Handle the Clazz "force deleted" event.
     */
    public function forceDeleted(Clazz $model): void
    {
        ClazzCacheKeys::clearCache();
        ClazzCacheKeys::clearCacheUpToLastPage(15,100, 'clazzs');

    }
}
