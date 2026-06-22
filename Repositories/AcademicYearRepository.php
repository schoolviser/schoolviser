<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\AcademicYear;
use Modules\Schoolviser\Cache\CacheKeys\AcademicYearCacheKeys as CacheKeys;

use App\Traits\Repositories\EnsureCompanyIsSet;

class AcademicYearRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(AcademicYear $model)
    {
        parent::__construct($model);
    }


    public function getAllYears()
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::ALL_YEARS.$this->companyId;

        return $this->cached($cacheKey, function(){
            return $this->model->whereCompanyId($this->companyId)->get();
        });
    }

    /**
     * Get the current academic year along with its associated terms.
      *
      * @return AcademicYear
      * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */

    public function getCurrentYear()
    {
        $this->ensureCompanyIsSet();
        return $this->model::whereCompanyId($this->companyId)->current()->with(['terms'])->first();
    }

     public function getCurrentAcademicYear()
    {
        $this->ensureCompanyIsSet();
        return $this->model::whereCompanyId($this->companyId)->current()->with([
            'terms:id,uuid,term,registration_deadline,academic_year_id,company_id'
            ])->first();
    }

    public function getYear($id)
    {
        $this->ensureCompanyIsSet();

        return $this->model::whereCompanyId($this->companyId)->whereId($id)->firstOrFail();
    }

    public function getYearByUuid($uuid)
    {
        $this->ensureCompanyIsSet();

        return $this->model::whereCompanyId($this->companyId)->whereUuid($uuid)->firstOrFail();
    }
    

    public function courseEnrollmentTrend($academicYearUuid)
    {
        $this->ensureCompanyIsSet();

        return $this->model::whereCompanyId($this->companyId)->whereUuid($academicYearUuid)->with(['terms'])->firstOrFail();
    }


   
   
}
