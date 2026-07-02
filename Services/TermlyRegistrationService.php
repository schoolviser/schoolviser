<?php

namespace Modules\Schoolviser\Services;

use Delgont\Core\Services\ModelService;

use App\Traits\Repositories\EnsureCompanyIsSet;
use Modules\Schoolviser\Entities\TermlyRegistration;
use Modules\Schoolviser\Entities\SecondaryStudent;

use Modules\Schoolviser\Cache\CacheKeys\TermlyRegistrationCacheKeys;
use Modules\Schoolviser\Cache\CacheKeys\SecondaryStudentCacheKeys;

class TermlyRegistrationService extends ModelService
{
    use EnsureCompanyIsSet;

    public function __construct(TermlyRegistration $model)
    {
        parent::__construct($model);
    }


    /**
     * Update student registrations
     */
    public function updateRegistration(SecondaryStudent $student, TermlyRegistration $termlyRegistration, array $data) : TermlyRegistration
    {
        $this->ensureCompanyIsSet();

        $this->run('before', 'updateRegistration', $termlyRegistration, $data);

        $termlyRegistration->fill([
            'residence'        => $data['residence'] ?? $termlyRegistration->residence,
            'clazz_id'         => $data['clazz_id'] ?? $termlyRegistration->clazz_id,
            'new_or_continuing'=> $data['new_or_continuing'] ?? $termlyRegistration->new_or_continuing,
            'hostel_id'        => $data['hostel_id'] ?? $termlyRegistration->hostel_id,
            'term_id'          => $data['term_id'] ?? $termlyRegistration->term_id,
        ]);

        $termlyRegistration->save();

        $this->run('after', 'updateRegistration', $termlyRegistration, $data);

        TermlyRegistrationCacheKeys::clearCacheWithKeysStarting('REGISTRATION', [$this->companyId, $termlyRegistration->uuid]);
        TermlyRegistrationCacheKeys::clearPaginatedRegistrationCache($termlyRegistration->company_id, $termlyRegistration->term_id, 15, 100);
        SecondaryStudentCacheKeys::clearCacheWithKeysEnding('PROFILE', [$this->companyId, $student->uuid]);

        return $termlyRegistration;
    }

     public function lockRegistration(TermlyRegistration $registration) : TermlyRegistration
    {
        $this->ensureCompanyIsSet();

        $registration->locked = true;
        $registration->save();

        StudentCacheKeys::clearStudentProfileCache($registration->company_id, $registration->student_id);
        return $registration;
    }

     public function unlockRegistration(TermlyRegistration $registration) : TermlyRegistration
    {
        $this->ensureCompanyIsSet();

        $registration->locked = false;
        $registration->save();

        StudentCacheKeys::clearStudentProfileCache($registration->company_id, $registration->student_id);
        return $registration;
    }


}