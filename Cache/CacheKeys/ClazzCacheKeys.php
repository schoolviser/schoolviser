<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class ClazzCacheKeys extends ModelCacheKeys
{
    const ALL_CLAZZES = 'All:Clazzes:';
    const CLAZZ = 'Clazz:';

    public static function clearClazzesCache($companyId)
    {
        self::forget(self::ALL_CLAZZES.$companyId);
    }

    public static function clearClazzCache($id)
    {
        self::forget(self::CLAZZ.$id);
    }

}
