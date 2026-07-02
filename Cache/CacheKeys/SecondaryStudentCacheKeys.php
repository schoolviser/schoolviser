<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;


class SecondaryStudentCacheKeys extends ModelCacheKeys
{
    const PAGINATED_TERM_STUDENTS = 'paginated:term:students:';


    # Single Student Cache Keys
    const STUDENT_PROFILE = 'student:profile:';
    const STUDENT_COMBINATION = 'student:combination:';
    const STUDENT_REGISTRATIONS = 'student:registrations:';

    # Term Specific data
    const TERM_STUDENTS = 'term:students:';
    const TERM_STUDENTS_PAGINATED = 'paginated:term:students:';
    const TERM_UNREGISTERED_STUDENTS_PAGINATED = 'paginated:term:unregistered:students:'; //append companyid:termId
    const TERM_UNREGISTERED_STUDENTS_SEARCH = 'term:unregistered:students:search:';

    public static function clearTermPaginatedCachedData($companyId, $termId, $perPage, $lastPage)
    {
        $cacheKeys = self::getCacheKeysStartingAndEnding('TERM', 'PAGINATED');

        foreach ($cacheKeys as $key) {
            # code...
            self::clearCacheUpToLastPage($perPage, $lastPage, $key . self::appendCacheSuffix($companyId, $termId, true));
        }
    }


}
