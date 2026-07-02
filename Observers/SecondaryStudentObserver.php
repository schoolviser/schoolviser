<?php

namespace Modules\Schoolviser\Observers;

use Modules\Schoolviser\Entities\SecondaryStudent;
 
use Modules\Schoolviser\Cache\CacheKeys\SecondaryStudentCacheKeys;

class SecondaryStudentObserver
{
    /**
     * Handle the SecondaryStudent "created" event.
     */
    public function created(SecondaryStudent $model): void
    {
        SecondaryStudentCacheKeys::clearCache($model->id);
        SecondaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'secondarystudents');
    }

    /**
     * Handle the SecondaryStudent "updated" event.
     */
    public function updated(SecondaryStudent $model): void
    {
        SecondaryStudentCacheKeys::clearCache($model->id);
        SecondaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'secondarystudents');

    }

    /**
     * Handle the SecondaryStudent "deleted" event.
     */
    public function deleted(SecondaryStudent $model): void
    {
        SecondaryStudentCacheKeys::clearCache($model->id);
        SecondaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'secondarystudents');

    }

    /**
     * Handle the SecondaryStudent "restored" event.
     */
    public function restored(SecondaryStudent $model): void
    {
        SecondaryStudentCacheKeys::clearCache($model->id);
        SecondaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'secondarystudents');

    }

    /**
     * Handle the SecondaryStudent "force deleted" event.
     */
    public function forceDeleted(SecondaryStudent $model): void
    {
        SecondaryStudentCacheKeys::clearCache($model->id);
        SecondaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'secondarystudents');

    }
}
