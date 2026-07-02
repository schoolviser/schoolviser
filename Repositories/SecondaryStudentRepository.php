<?php

namespace Modules\Schoolviser\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\SecondaryStudent;
use Modules\Schoolviser\Cache\CacheKeys\SecondaryStudentCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

# Models
use Modules\Schoolviser\Entities\Term;

class SecondaryStudentRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(SecondaryStudent $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all students of specific term
     */
    public function getTermStudents($termOrTermId)
    {
        $this->ensureCompanyIsSet();

        $termId = ($termOrTermId instanceof Term) ? $termOrTermId->id : $termOrTermId;

        $cacheKey = CacheKeys::TERM_STUDENTS . CacheKeys::appendCacheSuffix(false, $this->companyId, $termId);

        return $this->cached($cacheKey, function() use ($termId){
            return $this->model::whereCompanyId($this->companyId)->whereHas('termlyRegistrations', function($q) use ($termId){
                $q->whereTermId($termId);
            })->get();
        });
    }

    /**
     * Get paginated term students
     */
    public function getPaginatedTermStudents($termOrTermId, $perpage, $page, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();

        $termId = ($termOrTermId instanceof Term) ? $termOrTermId->id : $termOrTermId;

        $cacheKey = CacheKeys::PAGINATED_TERM_STUDENTS
            . CacheKeys::appendCacheSuffix(true, $this->companyId, $termId)
            . CacheKeys::appendPaginationCacheSuffix($perpage, $page);

        return $this->cached($cacheKey, function() use ($termId, $perpage, $page, $attributes) {
            return $this->model::whereCompanyId($this->companyId)
                ->whereHas('termlyRegistrations', fn($q) => $q->where('term_id', $termId))
                ->with(['termlyRegistration' => fn($q) => $q->where('term_id', $termId)->with('clazz')])
                ->paginate($perpage, $attributes, 'page', $page);
        });
    }

    public function getStudentMinimal($id)
    {
        $this->ensureCompanyIsSet();
        return $this->model::whereCompanyId($this->companyId)->where('uuid', $id)->firstOrFail();
    }

    public function getStudentProfile($studentId)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::STUDENT_PROFILE. CacheKeys::appendCacheSuffix(false, $this->companyId, $studentId);

        return $this->cachedForever($cacheKey, function() use ($studentId){
            return $this->model::with(['currentTermlyRegistration' => function($termlyRegQuery){
                $termlyRegQuery;
            }, 'termlyRegistrations'])->whereCompanyId($this->companyId)->where('uuid', $studentId)->firstOrFail();
        });
    }

     /**
     * Get unregistered students for a given intake.
     */
    public function getPaginatedTermUnregisteredStudents($termId, $perpage, $page, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::TERM_UNREGISTERED_STUDENTS_PAGINATED . CacheKeys::appendCacheSuffix($this->companyId, $termId, true) . CacheKeys::appendPaginationCacheSuffix($perpage, $page);

        return $this->cached($cacheKey, function() use ($termId, $perpage, $page, $attributes){
            return $this->model::whereCompanyId($this->companyId)->whereDoesntHave('termlyRegistrations', function ($q) use ($termId, $perpage, $page, $attributes) {
                $q->where('term_id', $termId);
            })->with([
                'termlyRegistrations.term',
            ])->paginate($perpage, $attributes, 'page', $page);
        });
    }

    public function searchTermUnregisteredStudents($termId, $search)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::TERM_UNREGISTERED_STUDENTS_SEARCH
            . CacheKeys::appendCacheSuffix($this->companyId, $termId)
            . ':' . md5($search);

        return $this->cached($cacheKey, function() use ($termId, $search) {
            return $this->model::whereCompanyId($this->companyId)
                ->whereDoesntHave('termlyRegistrations', function ($q) use ($termId) {
                    $q->where('term_id', $termId);
                })
                ->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('regno', 'like', "%{$search}%")
                    ->orWhere('access_number', 'like', "%{$search}%");
                })
                ->with(['termlyRegistrations.term'])
                ->get();
        });
    }



   
}
