<?php

namespace App\Observers;

use App\Entities\Department;
 
use App\Cache\CacheKeys\DepartmentCacheKeys;

class DepartmentObserver
{
    /**
     * Handle the Department "created" event.
     */
    public function created(Department $model): void
    {
        DepartmentCacheKeys::clearCache();
        DepartmentCacheKeys::clearCacheUpToLastPage(15,100, 'departments');
    }

    /**
     * Handle the Department "updated" event.
     */
    public function updated(Department $model): void
    {
        DepartmentCacheKeys::clearCache();
        DepartmentCacheKeys::clearCacheUpToLastPage(15,100, 'departments');

    }

    /**
     * Handle the Department "deleted" event.
     */
    public function deleted(Department $model): void
    {
        DepartmentCacheKeys::clearCache();
        DepartmentCacheKeys::clearCacheUpToLastPage(15,100, 'departments');

    }

    /**
     * Handle the Department "restored" event.
     */
    public function restored(Department $model): void
    {
        DepartmentCacheKeys::clearCache();
        DepartmentCacheKeys::clearCacheUpToLastPage(15,100, 'departments');

    }

    /**
     * Handle the Department "force deleted" event.
     */
    public function forceDeleted(Department $model): void
    {
        DepartmentCacheKeys::clearCache();
        DepartmentCacheKeys::clearCacheUpToLastPage(15,100, 'departments');

    }
}
