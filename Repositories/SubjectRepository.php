<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\Subject;
use Modules\Schoolviser\Cache\CacheKeys\SubjectCacheKeys as CacheKeys;

class SubjectRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Subject $model)
    {
        parent::__construct($model);
    }
   
}
