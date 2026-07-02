<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\Clazz;
use Modules\Schoolviser\Cache\CacheKeys\ClazzCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

use Delgont\Core\Entities\Any;

class ClazzRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Clazz $model)
    {
        parent::__construct($model);
    }


    public function getClazzes()
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::ALL_CLAZZES.$this->companyId;

        return $this->cachedForever($cacheKey, function(){
            return $this->model::whereCompanyId($this->companyId)->with(['streams'])->get();
        });

    }

    public function getClazz($id) : Clazz
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::CLAZZ.$id;
        return $this->cachedForever($cacheKey, function() use ($id){
            return $this->model::whereCompanyId($this->companyId)->whereId($id)->firstOrFail();
        });
    }


   
   
}
