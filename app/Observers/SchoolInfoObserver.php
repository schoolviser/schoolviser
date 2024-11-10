<?php

namespace App\Observers;

use App\Entities\SchoolInfo;
 
use App\Cache\CacheKeys\SchoolInfoCacheKeys;

class SchoolInfoObserver
{
    /**
     * Handle the SchoolInfo "created" event.
     */
    public function created(SchoolInfo $model): void
    {
        SchoolInfoCacheKeys::clearCache();
        SchoolInfoCacheKeys::clearCacheUpToLastPage(15,100, 'schoolinfos');
    }

    /**
     * Handle the SchoolInfo "updated" event.
     */
    public function updated(SchoolInfo $model): void
    {
        SchoolInfoCacheKeys::clearCache();
        SchoolInfoCacheKeys::clearCacheUpToLastPage(15,100, 'schoolinfos');

    }

    /**
     * Handle the SchoolInfo "deleted" event.
     */
    public function deleted(SchoolInfo $model): void
    {
        SchoolInfoCacheKeys::clearCache();
        SchoolInfoCacheKeys::clearCacheUpToLastPage(15,100, 'schoolinfos');

    }

    /**
     * Handle the SchoolInfo "restored" event.
     */
    public function restored(SchoolInfo $model): void
    {
        SchoolInfoCacheKeys::clearCache();
        SchoolInfoCacheKeys::clearCacheUpToLastPage(15,100, 'schoolinfos');

    }

    /**
     * Handle the SchoolInfo "force deleted" event.
     */
    public function forceDeleted(SchoolInfo $model): void
    {
        SchoolInfoCacheKeys::clearCache();
        SchoolInfoCacheKeys::clearCacheUpToLastPage(15,100, 'schoolinfos');

    }
}
