<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\SchoolInfo;
use Modules\Schoolviser\Cache\CacheKeys\SchoolInfoCacheKeys as CacheKeys;

use Delgont\Core\Entities\Any;

class SchoolInfoRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(SchoolInfo $model)
    {
        parent::__construct($model);
    }

    public function getInfo($map_keys = true)
    {
        return $this->cached(CacheKeys::SCHOOL_INFO, function() use ($map_keys){
            $hello = ($map_keys) ? $this->model->get()->mapWithKeys(function($item){
                return [$item->key => $item->value];
            }) : $this->model->all();

            return new Any($hello->toArray());
        });
    }
   
}
