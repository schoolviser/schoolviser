<?php

namespace Modules\Schoolviser\Services;

use App\Services\ModelBaseService;
use App\Traits\Repositories\EnsureCompanyIsSet;
use Modules\Schoolviser\Entities\Clazz;
use Modules\Schoolviser\Cache\CacheKeys\ClazzCacheKeys as CacheKeys;

class ClazzService extends ModelBaseService
{
    use EnsureCompanyIsSet;


    public function __construct(Clazz $model)
    {
        parent::__construct($model);
    }

    public function createClazz($data): Clazz
    {
        $this->ensureCompanyIsSet();

        $data = (object) $data;

        $clazz = new $this->model;
        $clazz->name = $data->name;
        $clazz->abbr = $data->abbr;
        $clazz->level = $data->level ?? 'ordinary';
        $clazz->company_id = $this->companyId;

        $clazz->save();

        CacheKeys::clearClazzesCache($this->companyId);

        return $clazz;
    }

    public function updateClazz(Clazz $clazz, $data) : Clazz
    {
        $this->ensureCompanyIsSet();

        $data = (object) $data;

        $clazz->name = $data->name;
        $clazz->abbr = $data->abbr;
        $clazz->level = $data->level ?? 'ordinary';

        $clazz->save();

        CacheKeys::clearClazzesCache($this->companyId);
        CacheKeys::clearClazzCache($clazz->id);

        return $clazz;
    }

    public function deleteClazz(Clazz $clazz): bool
    {
        $this->ensureCompanyIsSet();

        // Check if the class has any linked termly registrations
        if ($clazz->termlyRegistrations()->exists()) {
            // Do not delete if registrations exist
            return false;
        }

         // Clear caches
        CacheKeys::clearClazzesCache($this->companyId);
        CacheKeys::clearClazzCache($clazz->id);

        // Safe to delete
        $clazz->delete();

        return true;
    }

}