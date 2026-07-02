<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\TertiaryStudent;
use Modules\Schoolviser\Cache\CacheKeys\TertiaryStudentCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

class TertiaryStudentReposiory extends BaseRepository
{
    use EnsureCompanyIsSet;

    public function __construct(TertiaryStudent $model)
    {
        parent::__construct($model);
    }

    /**
     * Quick get the student details - Pure student no relationships
     */
    public function getStudent($studentId)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::STUDENT.CacheKeys::appendCacheSuffix(false, $this->companyId,$studentId);

        return $this->cachedForever($cacheKey, function() use ($studentId){
            return $this->model::whereCompanyId($this->companyId)->where('uuid', $studentId)->firstOrFail();
        });

    }

    public function getStudentById($studentId)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::STUDENT.CacheKeys::appendCacheSuffix(false, $this->companyId,$studentId);

        return $this->cachedForever($cacheKey, function() use ($studentId){
            return $this->model::whereCompanyId($this->companyId)->where('id', $studentId)->firstOrFail();
        });

    }


    public function getStudentProfile($studentId)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::STUDENT_PROFILE.CacheKeys::appendCacheSuffix(false, $this->companyId,$studentId);

        return $this->cached($cacheKey, function() use ($studentId){
            return $this->model::with(['course', 'currentIntakeRegistration', 'courseGroup','intakeRegistrations' => function($intakeRegistrationsQuery){
                $intakeRegistrationsQuery->whereCompanyId($this->companyId)->with('term','academicYear');
            }])->whereCompanyId($this->companyId)->where('uuid', $studentId)->firstOrFail();
        });
    }

    /**
     * Get unregistered students for a given intake.
     */
    public function getPaginatedUnregisteredStudents($intake_id)
    {
        $this->ensureCompanyIsSet();

        return $this->model::whereCompanyId($this->companyId)
            ->whereDoesntHave('intakeRegistrations', function ($q) use ($intake_id) {
                $q->where('term_id', $intake_id);
            })
            ->with([
                'course',
                'intakeRegistrations.term',
                'courseGroup'
            ])
            ->paginate();
    }

   
}
