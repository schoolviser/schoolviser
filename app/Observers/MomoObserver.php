<?php

namespace App\Observers;

use App\Entities\Momo;
 
use App\Cache\CacheKeys\MomoCacheKeys;

class MomoObserver
{
    /**
     * Handle the Momo "created" event.
     */
    public function created(Momo $model): void
    {
        MomoCacheKeys::clearCache($model->id);
        MomoCacheKeys::clearCacheUpToLastPage(15,100, 'momos');
    }

    /**
     * Handle the Momo "updated" event.
     */
    public function updated(Momo $model): void
    {
        MomoCacheKeys::clearCache($model->id);
        MomoCacheKeys::clearCacheUpToLastPage(15,100, 'momos');

    }

    /**
     * Handle the Momo "deleted" event.
     */
    public function deleted(Momo $model): void
    {
        MomoCacheKeys::clearCache($model->id);
        MomoCacheKeys::clearCacheUpToLastPage(15,100, 'momos');

    }

    /**
     * Handle the Momo "restored" event.
     */
    public function restored(Momo $model): void
    {
        MomoCacheKeys::clearCache($model->id);
        MomoCacheKeys::clearCacheUpToLastPage(15,100, 'momos');

    }

    /**
     * Handle the Momo "force deleted" event.
     */
    public function forceDeleted(Momo $model): void
    {
        MomoCacheKeys::clearCache($model->id);
        MomoCacheKeys::clearCacheUpToLastPage(15,100, 'momos');

    }
}
