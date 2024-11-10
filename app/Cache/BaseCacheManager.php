<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;
use App\Cache\CacheRegistry\BaseCacheRegistry as CacheRegistry;

abstract class BaseCacheManager
{
    protected $cacheRegistry;

    public function __construct( CacheRegistry $cacheRegistry )
    {
        $this->cacheRegistry = $cacheRegistry;
    }

    //Clear cached data
    public function clear() : void
    {
        $keys = $this->cacheRegistry->getCacheKeys();
        if(count($keys) > 0){
            foreach ($keys as $key => $value) {
                Cache::forget($value);
            }
        }
    }

    protected function clearFromCache($key) : void
    {
        Cache::forget($key);
    }
}
