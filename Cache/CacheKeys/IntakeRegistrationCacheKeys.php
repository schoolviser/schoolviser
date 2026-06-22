<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class IntakeRegistrationCacheKeys extends ModelCacheKeys
{
    const INTAKE_REGISTRATIONS = 'Intake:Registrations';

    const CURRENT_REGISTRATIONS = 'Current:Registrations';
    const CURRENT_PAGINATED_REGISTRATIONS = 'Current:Paginated:Registrations:';

    const PREVIOUS_REGISTRATIONS = 'Previous:Registrations';

    const TOTAL_CURRENT_REGISTRATIONS = 'Total:Current:Registrations';
    const TOTAL_PREVIOUS_REGISTRATIONS = 'Total:Previous:Registrations';

    public static function clearCurrentPaginatedRegistrationsCache($perPage, $lastPage, $companyId)
    {
        self::clearCacheUpToLastPage($perPage, $lastPage ?? 50, self::CURRENT_PAGINATED_REGISTRATIONS.$companyId.':');
    }

}
