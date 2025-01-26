<?php

namespace App\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use App\Entities\Momo;
use App\Cache\CacheKeys\MomoCacheKeys as CacheKeys;
use Delgont\Core\Entities\Any;


class MomoSettingRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Momo $model)
    {
        parent::__construct($model);
    }

     public function getSettings($map_keys = true)
    {
        return $this->cached(CacheKeys::MOMO_SETTINGS, function() use ($map_keys){
            $hello = ($map_keys) ? $this->model->get()->mapWithKeys(function($item){
                return [$item->key => $item->value];
            }) : $this->model->all();

            return new Any($hello->toArray());
        });
    }

}
