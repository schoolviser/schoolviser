<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\Course;
use Modules\Schoolviser\Cache\CacheKeys\CourseCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

class CourseRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    /*
     * Return all courses without pagination or relations.
     * Only minimal fields for dropdowns or AJAX selects.
     */
    public function getAllCoursesMinimal()
    {
        $this->ensureCompanyIsSet();

        return $this->model->newQuery()
        ->whereCompanyId($this->companyId)
        ->select(['id', 'name'])
        ->get();
    }

    public function getAllCourses()
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::ALL_COURSES.$this->companyId;

        return $this->cachedForever($cacheKey, function(){
            return $this->model->whereCompanyId($this->companyId)->get();
        });
    }


    public function getPaginatedCouses(int $perPage, $page, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::PAGINATED_COURSES.$this->companyId . ":" . CacheKeys::paginatedCacheSuffix($perPage, $page);

        return $this->cachedForever($cacheKey, function() use ($perPage, $page, $attributes){
            return $this->model::whereCompanyId($this->companyId)->paginate($perPage, $attributes, 'page', $page);
        });

    }

    public function getCourse($course_id) : Course
    {
        $this->ensureCompanyIsSet();
        return $this->model::whereCompanyId($this->companyId)->whereId($course_id)->firstOrFail();

    }

    
   
}
