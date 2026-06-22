<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\Department;
use Modules\Schoolviser\Cache\CacheKeys\DepartmentCacheKeys as CacheKeys;

class DepartmentRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function getDepartments()
    {
        return $this->cached(CacheKeys::DEPARTMENTS, function(){
            return $this->model->get();
        });
    }
   
}
