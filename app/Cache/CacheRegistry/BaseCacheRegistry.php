<?php

namespace App\Cache\CacheRegistry;

use Illuminate\Database\Eloquent\Model;

abstract class BaseCacheRegistry
{
    public $cacheKeys = null;

    public function getCacheKeys()
    {
        return ($this->cacheKeys) ? $this->cacheKeys : (new \ReflectionClass($this))->getConstants();
    }
}
