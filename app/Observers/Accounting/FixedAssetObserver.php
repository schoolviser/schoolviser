<?php

namespace App\Observers\Accounting;

use App\Models\Accounting\Coa\FixedAsset;

use App\Cache\CoaCacheManager;

class FixedAssetObserver
{
    /**
     * Handle the fixed asset "created" event.
     *
     * @param  \App\Models\Accounting\Coa\FixedAsset  $fixedAsset
     * @return void
     */
    public function created(FixedAsset $fixedAsset)
    {
        CoaCacheManager::clearFixedAssetsFromCache();
    }

    /**
     * Handle the fixed asset "updated" event.
     *
     * @param  \App\Models\Accounting\Coa\FixedAsset  $fixedAsset
     * @return void
     */
    public function updated(FixedAsset $fixedAsset)
    {
        //
        CoaCacheManager::clearFixedAssetsFromCache();

    }

    /**
     * Handle the fixed asset "deleted" event.
     *
     * @param  \App\Models\Accounting\Coa\FixedAsset  $fixedAsset
     * @return void
     */
    public function deleted(FixedAsset $fixedAsset)
    {
        //
        CoaCacheManager::clearFixedAssetsFromCache();

    }

    /**
     * Handle the fixed asset "restored" event.
     *
     * @param  \App\Models\Accounting\Coa\FixedAsset  $fixedAsset
     * @return void
     */
    public function restored(FixedAsset $fixedAsset)
    {
        //
        CoaCacheManager::clearFixedAssetsFromCache();

    }

    /**
     * Handle the fixed asset "force deleted" event.
     *
     * @param  \App\Models\Accounting\Coa\FixedAsset  $fixedAsset
     * @return void
     */
    public function forceDeleted(FixedAsset $fixedAsset)
    {
        //
        CoaCacheManager::clearFixedAssetsFromCache();

    }
}
