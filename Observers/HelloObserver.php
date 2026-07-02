<?php

namespace Modules\Schoolviser\Observers;

use Modules\Schoolviser\Entities\Hello;
 
use Modules\Schoolviser\Cache\CacheKeys\HelloCacheKeys;

class HelloObserver
{
    /**
     * Handle the Hello "created" event.
     */
    public function created(Hello $model): void
    {
        HelloCacheKeys::clearCache($model->id);
        HelloCacheKeys::clearCacheUpToLastPage(15,100, 'hellos');
    }

    /**
     * Handle the Hello "updated" event.
     */
    public function updated(Hello $model): void
    {
        HelloCacheKeys::clearCache($model->id);
        HelloCacheKeys::clearCacheUpToLastPage(15,100, 'hellos');

    }

    /**
     * Handle the Hello "deleted" event.
     */
    public function deleted(Hello $model): void
    {
        HelloCacheKeys::clearCache($model->id);
        HelloCacheKeys::clearCacheUpToLastPage(15,100, 'hellos');

    }

    /**
     * Handle the Hello "restored" event.
     */
    public function restored(Hello $model): void
    {
        HelloCacheKeys::clearCache($model->id);
        HelloCacheKeys::clearCacheUpToLastPage(15,100, 'hellos');

    }

    /**
     * Handle the Hello "force deleted" event.
     */
    public function forceDeleted(Hello $model): void
    {
        HelloCacheKeys::clearCache($model->id);
        HelloCacheKeys::clearCacheUpToLastPage(15,100, 'hellos');

    }
}
