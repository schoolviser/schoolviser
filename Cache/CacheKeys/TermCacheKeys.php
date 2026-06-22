<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class TermCacheKeys extends ModelCacheKeys
{
    const ALL_TERMS = 'Terms:All:';
    const ACTIVE_TERMS = 'Active:Terms:';
    const TERM = 'Term:';
    const CURRENT_TERM = 'Term:Current:';

    const PREVIOUS_TERM = 'Term:Previous:';
    const TOTAL_REGISTRATIONS_PER_TERM = 'Total:Registrations:Per:Term:';

    public static function clearTermsCache($companyId)
    {
        self::forget(self::ALL_TERMS.$companyId);
    }

    public static function clearTermCache($term_id)
    {
        self::forget(self::TERM.$term_id);
    }
    
    public static function clearCurrentTerm($companyId)
    {
        self::forget(self::CURRENT_TERM.$companyId);
    }

}
