<?php

namespace App\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use App\Entities\Clazz;
use App\Cache\CacheKeys\ClazzCacheKeys as CacheKeys;

use Delgont\Core\Entities\Any;

class ClazzRespository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Clazz $model)
    {
        parent::__construct($model);
    }


    public function getClazzes()
    {
        return $this->cached(CacheKeys::CLAZZES, function(){
            return $this->model->get()->map(function($item, $key){
                return new Any([
                    'id' => $item->id,
                    'name' => $item->name,
                    'abbr' => $item->abbr,
                    'level' => $item->level,
                    'protected' => true
                ]);
            });
        });
    }


   
   
}
