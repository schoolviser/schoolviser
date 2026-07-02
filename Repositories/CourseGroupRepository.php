<?php

namespace Modules\Schoolviser\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\CourseGroup;
use Modules\Schoolviser\Cache\CacheKeys\CourseGroupCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

class CourseGroupRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    public function __construct(CourseGroup $model)
    {
        parent::__construct($model);
    }

    public function getCourseGroup($id)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::COURSE_GROUP . CacheKeys::appendCacheSuffix(false, $this->companyId,$id);

        return $this->cachedForever($cacheKey, function() use ($id){
            return $this->model::whereCompanyId($this->companyId)->where('uuid', $id)->firstOrFail();
        });
    }

    public function getPaginatedCourseGroups($perPage = 15, $page = 1, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();
        $cacheKey = CacheKeys::PAGINATED_COURSE_GROUPS . CacheKeys::appendCacheSuffix(true, $this->companyId) . CacheKeys::appendPaginationCacheSuffix($perPage, $page);

        return $this->cached($cacheKey, function() use ($perPage, $page, $attributes){
            return $this->model::whereCompanyId($this->companyId)->paginate($perPage, $attributes, 'page', $page);
        });

    }


   
}
