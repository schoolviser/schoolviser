<?php

namespace App\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use App\Entities\Department;
use App\Cache\CacheKeys\DepartmentCacheKeys as CacheKeys;

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
