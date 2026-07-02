<?php
namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use App\Traits\Repositories\EnsureCompanyIsSet;

use Modules\Schoolviser\Entities\Term;
use Modules\Schoolviser\Cache\CacheKeys\TermCacheKeys as CacheKeys;

class TermRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Term $model)
    {
        parent::__construct($model);
    }

    public function getYearTermsMinimal($yearId)
    {
        $this->ensureCompanyIsSet();
        return $this->model::whereCompanyId($this->companyId)->whereAcademicYearId($yearId)->get();
    }

    public function getAllTerms()
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::ALL_TERMS.$this->companyId;

        return $this->cachedForever($cacheKey, function(){
            return $this->model->whereCompanyId($this->companyId)->with(['academicYear'])->orderBy('created_at', 'desc')->get();
        });
    }

    public function getActiveTerms()
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::ACTIVE_TERMS.$this->companyId;

        return $this->cached($cacheKey, function(){
            return $this->model::whereCompanyId($this->companyId)->active()->get();
        });
    }

    public function getAll()
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::ALL_TERMS.$this->companyId;

        return $this->cachedForever($cacheKey, function(){
            return $this->model::whereCompanyId($this->companyId)->get();
        });
    }

    /**
     * Get a term by its ID or UUID.
     */
    public function getTerm($id)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::TERM.$id;

        return $this->cachedForever($cacheKey, function () use ($id) {
            return $this->model::whereCompanyId($this->companyId)->with(['academicYear:id,uuid,name,start_date,end_date'])
                ->orWhere('uuid', $id)
                ->firstOrFail();
        });
    }


    /**
     * Get the current active term for the company/school.
     */
    public function getCurrentTerm()
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::CURRENT_TERM.$this->companyId;

        return $this->cached($cacheKey, function(){
            return $this->model::whereCompanyId($this->companyId)->current()->with(['academicYear:id,uuid,name,start_date,end_date'])->first();
        });
    }

    //Get the previous term
    public function getPreviousTerm()
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::PREVIOUS_TERM.$this->companyId;

        return $this->cached($cacheKey, function(){
            return $this->model::whereCompanyId($this->companyId)->previous()->first();
        });
    }


    public function getTotalRegistrationsPerIntake()
    {
         $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::TOTAL_REGISTRATIONS_PER_TERM.$this->companyId;

        return $this->cached(CacheKeys::TOTAL_REGISTRATIONS_PER_TERM, function(){
            return $this->model::whereCompanyId($this->companyId)->withCount('intakeRegistrations')->get();
        });
    }

    /**
     * Get total registrations per intake for a specific academic year
     */
    public function getTotalRegistrationsPerIntakeInAcademicYear($year_id)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::TOTAL_REGISTRATIONS_PER_TERM_IN_ACADEMIC_YEAR. $this->companyId . ':' . $year_id;

        return $this->cached($cacheKey, function () use ($year_id) {
            return $this->model::whereCompanyId($this->companyId)->whereAcademicYearId($year_id)
                ->withCount(['intakeRegistrations' => function ($q) use ($year_id) {
                    $q->where('academic_year_id', $year_id);
                }])
                ->get();
        });
    }



}
