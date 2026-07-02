<?php
/**
 * Delxero Engine (https://delgont.co.ug)
 *
 * @copyright Copyright (c) 2026. Delgont Technologies
 *
 * @license Proprietary License - Unauthorized modification or redistribution prohibited.
 * Licensed users may only use this software to host applications and develop modules
 * that extend Delxero Engine, subject to a valid license agreement.
 */

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
