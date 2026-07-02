<?php

namespace Modules\Schoolviser\Observers;

use Modules\Schoolviser\Entities\CourseGroup;
 
use Modules\Schoolviser\Cache\CacheKeys\CourseGroupCacheKeys;

class CourseGroupObserver
{
    /**
     * Handle the CourseGroup "created" event.
     */
    public function created(CourseGroup $model): void
    {
        CourseGroupCacheKeys::clearCache($model->id);
        CourseGroupCacheKeys::clearCacheUpToLastPage(15,100, 'coursegroups');
    }

    /**
     * Handle the CourseGroup "updated" event.
     */
    public function updated(CourseGroup $model): void
    {
        CourseGroupCacheKeys::clearCache($model->id);
        CourseGroupCacheKeys::clearCacheUpToLastPage(15,100, 'coursegroups');

    }

    /**
     * Handle the CourseGroup "deleted" event.
     */
    public function deleted(CourseGroup $model): void
    {
        CourseGroupCacheKeys::clearCache($model->id);
        CourseGroupCacheKeys::clearCacheUpToLastPage(15,100, 'coursegroups');

    }

    /**
     * Handle the CourseGroup "restored" event.
     */
    public function restored(CourseGroup $model): void
    {
        CourseGroupCacheKeys::clearCache($model->id);
        CourseGroupCacheKeys::clearCacheUpToLastPage(15,100, 'coursegroups');

    }

    /**
     * Handle the CourseGroup "force deleted" event.
     */
    public function forceDeleted(CourseGroup $model): void
    {
        CourseGroupCacheKeys::clearCache($model->id);
        CourseGroupCacheKeys::clearCacheUpToLastPage(15,100, 'coursegroups');

    }
}
