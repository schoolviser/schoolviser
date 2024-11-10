<?php

namespace App\Cache;

use App\Cache\CacheKeyRegistry\SchoolPayCacheRegistry;

use Illuminate\Support\Facades\Cache;


class SchoolPayCacheManager
{
    public function __construct()
    {
        $this->cacheRegistry = app(SchoolPayCacheRegistry::class);
    }

    public static function setCacheRegistry()
    {
        $this->cacheRegistry = app(SchoolPayCacheRegistry::class);
        return $this;
    }


    public function clearCache()
    {
        Cache:forget($this->cacheRegistry::CURRENT_TRANSACTIONS_CACHE_KEY);
        return $this;
    }
}
