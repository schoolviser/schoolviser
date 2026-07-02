<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class IntakeRegistrationCacheKeys extends ModelCacheKeys
{
    const INTAKE_REGISTRATION = 'intake:registration:';
    const INTAKE_REGISTRATIONS = 'intake:registrations';
    const PAGINATED_INTAKE_REGISTRATIONS = 'paginated:intake:registrations:';

    const CURRENT_REGISTRATIONS = 'Current:Registrations';
    const CURRENT_PAGINATED_REGISTRATIONS = 'Current:Paginated:Registrations:';

    const PREVIOUS_REGISTRATIONS = 'Previous:Registrations';

    const TOTAL_CURRENT_REGISTRATIONS = 'Total:Current:Registrations';
    const TOTAL_PREVIOUS_REGISTRATIONS = 'Total:Previous:Registrations';

    public static function clearIntakeRegistrationCachedData($companyId, $intakeRegistrationIds)
    {
        // Normalize to array
        $ids = is_array($intakeRegistrationIds) ? $intakeRegistrationIds : [$intakeRegistrationIds];

        foreach ($ids as $id) {
            self::forget(self::INTAKE_REGISTRATION . $companyId . ':' . $id);
        }

    }

    public static function clearPaginatedIntakeRegistrationsCachedData($companyId, $intakeId, $perpage, $lastpage)
    {
        $cachePrefix = self::PAGINATED_INTAKE_REGISTRATIONS . self::appendCacheSuffix(true, $companyId, $intakeId);
        $instance = new static();
        $instance->clearPaginatedCache($perpage, $lastpage, $cachePrefix);
    }



}
