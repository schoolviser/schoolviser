<?php

namespace Modules\Schoolviser\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\Hello;
use Modules\Schoolviser\Cache\CacheKeys\HelloCacheKeys as CacheKeys;

class HelloRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Hello $model)
    {
        parent::__construct($model);
    }
   
}
