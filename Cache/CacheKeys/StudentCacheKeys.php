<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class StudentCacheKeys extends ModelCacheKeys
{
    const KEY_CONSTANT = 'your:key';

    const STUDENT_PROFILE = 'Student:Profile:';
    const TERTIARY_STUDENT_PROFILE = 'TertiaryStudent:Profile:';

    public static function clearStudentProfileCache($companyId, $studentId)
    {
        self::forget(self::STUDENT_PROFILE.$companyId.':'.$studentId);
    }

    public static function clearTertiaryStudentProfileCache($companyId, $studentId)
    {
        self::forget(self::TERTIARY_STUDENT_PROFILE.$companyId.':'.$studentId);
    }

}
