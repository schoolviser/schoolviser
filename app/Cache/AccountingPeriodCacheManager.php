<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;

use App\Cache\CacheKeyRegistry\AccountingPeriodCacheKeyRegistry;


class AccountingPeriodCacheManager
{

    protected $cacheKeyRegistry;

    public function __construct()
    {
        $this->cacheKeyRegistry = app(AccountingPeriodCacheKeyRegistry::class);
    }

    

    public function clearCurrentPeriodFromCache()
    {
        Cache::forget($this->cacheKeyRegistry::CURRENT_PERIOD_CACHE_KEY);
        return true;
    }

    public function clearPreviousPeriodFromCache()
    {
        Cache::forget($this->cacheKeyRegistry::PREVIOUS_PERIOD_CACHE_KEY);
        return true;
    }


    public function clearPeriodsFromCache()
    {
        Cache::forget($this->cacheKeyRegistry::PERIODS_CACHE_KEY);
        return true;
    }

    public function clearAll()
    {
        self::clearCurrentPeriodFromCache();
        self::clearPreviousPeriodFromCache();
        self::clearPeriodsFromCache();
        return true;
    }



}
