<?php

namespace App\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use App\Entities\Subject;
use App\Cache\CacheKeys\SubjectCacheKeys as CacheKeys;

class SubjectRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Subject $model)
    {
        parent::__construct($model);
    }
   
}
