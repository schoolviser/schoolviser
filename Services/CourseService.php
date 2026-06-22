<?php

namespace Modules\Schoolviser\Services;

use App\Services\ModelBaseService;
use App\Traits\Repositories\EnsureCompanyIsSet;
use Modules\Schoolviser\Entities\Course;
use Modules\Schoolviser\Cache\CacheKeys\CourseCacheKeys as CacheKeys;

class CourseService extends ModelBaseService
{
    use EnsureCompanyIsSet;

    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    public function createCourse($data): Course
    {
        $this->ensureCompanyIsSet();

        $data = (object) $data;

        $course = new $this->model;

        $course->name = $data->name;
        $course->abbr = $data->short_name;
        $course->duration = $data->duration;
        //$course->description = $data->description;
        //$course->department_id = $request->department;
        $course->company_id = $this->companyId;

        $course->save();

        CacheKeys::clearPaginatedCoursesCache($this->companyId);

        return $course;
    }

     /**
     * Update an existing term.
     */
    public function updateCourse(Course $course, $data): Course
    {
        $this->ensureCompanyIsSet();

        $data = (object) $data;

        $course->name = $data->name;
        $course->abbr = $data->short_name;
        $course->duration = $data->duration;
        //$course->description = $data->description;
        //$course->department_id = $request->department;
        //$course->company_id = $this->companyId;

        $course->save();

        CacheKeys::clearCourseCache($course->id);
        CacheKeys::clearPaginatedCoursesCache($this->companyId);

        return $course;
    }


    /**
     * Delete a term only if it has no dependent relations.
     */
    public function deleteCourse(Course $course): bool
    {
        $this->ensureCompanyIsSet();

        // Example relation: termlyRegistrations
        if ($course->students()->exists()) {
            return false; // cannot delete
        }

        $course->delete();
        CacheKeys::clearPaginatedCoursesCache($this->companyId);
        CacheKeys::clearCourseCache($course->id);

        return true;
    }

}