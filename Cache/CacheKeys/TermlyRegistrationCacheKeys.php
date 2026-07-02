<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class TermlyRegistrationCacheKeys extends ModelCacheKeys
{

    const REGISTRATION = 'Registration:';
    const PAGINATED_REGISTRATIONS = 'Paginated:Registrations:';
    const TERM_REGISTRATIONS_PAGINATED = 'TErm:Paginated:Registrations:';

    const CURRENT_REGISTRATIONS = 'Current:Registrations';
    const PREVIOUS_REGISTRATIONS = 'Previous:Registrations';

    const TOTAL_CURRENT_REGISTRATIONS = 'Total:Current:Registrations';
    const TOTAL_PREVIOUS_REGISTRATIONS = 'Total:Previous:Registrations';


    public static function clearPaginatedRegistrationCache($companyId, $term_id, $perPage, $lastPage){
        $cachePrefix = self::PAGINATED_REGISTRATIONS . self::appendCacheSuffix(true, $companyId, $term_id);
        self::clearCacheUpToLastPage($perPage, $lastPage, $cachePrefix);
    }

    public static function clearPaginatedRegistrationCachedData($companyId, $termId, $perpage, $lastpage)
    {
        $cachePrefixes = self::getCacheKeysStartingAndEnding('TERM', 'PAGINATED');
        foreach ($cachePrefixes as $key) {
            self::clearCacheUpToLastPage($perpage, $lastpage, $key . self::appendCacheSuffix(true,$companyId, $termId));
        }
    }
    
}