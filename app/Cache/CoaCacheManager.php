<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;

class CoaCacheManager
{
    const CACHE_PREFIX = 'coas';


    /**
     * Clear cache
     */

     public static function clearCache()
     {
        self::clearExpensesFromCache();
        self::clearRevenuesFromCache();
        self::clearFixedAssetsFromCache();
     }

     public static function clearExpensesFromCache( $reCache = false)
     {
        Cache::forget(self::CACHE_PREFIX.':'.'expenses');
        Cache::forget(self::CACHE_PREFIX.':'.'expenses:hierarchical');
     }

     public static function clearRevenuesFromCache( $reCache = false)
     {
        Cache::forget(self::CACHE_PREFIX.':'.'revenues');
        Cache::forget(self::CACHE_PREFIX.':'.'revenues:hierarchical');
     }

     public static function clearFixedAssetsFromCache( $reCache = false)
     {
        Cache::forget(self::CACHE_PREFIX.':'.'fixedassets');
        Cache::forget(self::CACHE_PREFIX.':'.'fixedassets:hierarchical');
     }
}
