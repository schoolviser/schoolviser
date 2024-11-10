<?php

namespace App\Cache;

use App\Cache\BaseCacheManager;
use App\Cache\CacheRegistry\EmployeeCacheRegistry;

class EmployeeCacheManager extends BaseCacheManager
{
    public function __construct( EmployeeCacheRegistry $cacheRegistry )
    {
        parent::__construct($cacheRegistry);
    }
    
}
