<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class TertiaryStudentCacheKeys extends ModelCacheKeys
{
    # Single student cache keys
    const STUDENT_PROFILE = 'student:profile:';
    const STUDENT = 'student:';

    /**
     * Clear cached student profile(s).
     *
     * @param int|string|array $studentIds  Single ID/UUID or array of IDs/UUIDs
     * @param int|string       $companyId   Company identifier
     */
   public static function clearStudentProfileCachedData($companyId, $studentIds)
    {
        $ids = is_array($studentIds) ? $studentIds : [$studentIds];
        foreach ($ids as $id) {
            self::forget(
                self::STUDENT_PROFILE . self::appendCacheSuffix(false, $companyId, $id)
            );
        }
    }

}
