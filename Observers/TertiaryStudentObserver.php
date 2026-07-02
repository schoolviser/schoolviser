<?php

namespace Modules\Schoolviser\Observers;

use TertiaryStudent;
 
use Modules\Schoolviser\Cache\CacheKeys\TertiaryStudentCacheKeys;

class TertiaryStudentObserver
{
    /**
     * Handle the TertiaryStudent "created" event.
     */
    public function created(TertiaryStudent $model): void
    {
        TertiaryStudentCacheKeys::clearCache($model->id);
        TertiaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'tertiarystudents');
    }

    /**
     * Handle the TertiaryStudent "updated" event.
     */
    public function updated(TertiaryStudent $model): void
    {
        TertiaryStudentCacheKeys::clearCache($model->id);
        TertiaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'tertiarystudents');

    }

    /**
     * Handle the TertiaryStudent "deleted" event.
     */
    public function deleted(TertiaryStudent $model): void
    {
        TertiaryStudentCacheKeys::clearCache($model->id);
        TertiaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'tertiarystudents');

    }

    /**
     * Handle the TertiaryStudent "restored" event.
     */
    public function restored(TertiaryStudent $model): void
    {
        TertiaryStudentCacheKeys::clearCache($model->id);
        TertiaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'tertiarystudents');

    }

    /**
     * Handle the TertiaryStudent "force deleted" event.
     */
    public function forceDeleted(TertiaryStudent $model): void
    {
        TertiaryStudentCacheKeys::clearCache($model->id);
        TertiaryStudentCacheKeys::clearCacheUpToLastPage(15,100, 'tertiarystudents');

    }
}
