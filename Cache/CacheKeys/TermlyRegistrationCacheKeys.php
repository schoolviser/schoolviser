<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class TermlyRegistrationCacheKeys extends ModelCacheKeys
{

    const REGISTRATION = 'Registration:';
    const PAGINATED_REGISTRATIONS = 'Paginated:Registrations:';

    const CURRENT_REGISTRATIONS = 'Current:Registrations';
    const PREVIOUS_REGISTRATIONS = 'Previous:Registrations';

    const TOTAL_CURRENT_REGISTRATIONS = 'Total:Current:Registrations';
    const TOTAL_PREVIOUS_REGISTRATIONS = 'Total:Previous:Registrations';


    public static function clearPaginatedRegistrationCache($companyId, $term_id, $perPage, $lastPage){
        $cachePrefix = self::PAGINATED_REGISTRATIONS.$companyId.':'.$term_id.':';
        self::clearCacheUpToLastPage($perPage, $lastPage, $cachePrefix);
    }

     public static function clearRegistrationCache($registration_id){
        $cacheKey = self::REGISTRATION.$registration_id;
        self::forget($cacheKey);
    }

    
}