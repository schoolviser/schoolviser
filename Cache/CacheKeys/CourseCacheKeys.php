<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class CourseCacheKeys extends ModelCacheKeys
{
    const ALL_COURSES = 'All:Courses:';
    const PAGINATED_COURSES = 'Paginated:Courses:';
    const COURSE = 'Course:';


    public static function clearCoursesCache($companyId)
    {
        self::forget(self::ALL_COURSES.$companyId);
    }

    public static function clearCourseCache($courseId)
    {
        self::forget(self::COURSE.$courseId);
    }

     public static function clearPaginatedCoursesCache(int $companyId, $perPage = 10, $maxPages = 100)
    {
        $baseKey = self::PAGINATED_COURSES . $companyId . ':';
        self::clearCacheUpToLastPage($perPage, $maxPages, $baseKey);
    }

}
