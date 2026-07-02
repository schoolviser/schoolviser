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

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\Student;
use Modules\Schoolviser\Entities\Term;

use Modules\Schoolviser\Cache\CacheKeys\StudentCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

use Mpdules\Schoolviser\Entities\IntakeRegistration;

class StudentRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Student $model)
    {
        parent::__construct($model);
    }


    public function getStudentProfile($studentId)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::STUDENT_PROFILE.$this->companyId.':'.$studentId;

        return $this->cachedForever($cacheKey, function() use ($studentId){
            return $this->model::with(['currentTermlyRegistration' => function($termlyRegQuery){
                $termlyRegQuery;
            }, 'termlyRegistrations'])->whereCompanyId($this->companyId)->findOrFail($studentId);
        });
    }

   

    /**
     * Get
     */
    public function getUnregisteredTertiaryStudents(Term $term)
    {
        $this->ensureCompanyIsSet();

        return Student::whereCompanyId($this->companyId)->with(['intakeRegistrations'])
            ->whereDoesntHave('intakeRegistrations', function ($query) use ($term) {
                $query->where('term_id', $term->id)
                    ->where('academic_year_id', $term->academic_year_id);
            })
            ->paginate(15);
    }
    
}




