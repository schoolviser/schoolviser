<?php

namespace Modules\Schoolviser\Services;

use App\Services\ModelBaseService;
use App\Traits\Repositories\EnsureCompanyIsSet;
use Modules\Schoolviser\Entities\TermlyRegistration;
use Modules\Schoolviser\Cache\CacheKeys\TermlyRegistrationCacheKeys as CacheKeys;
use Modules\Schoolviser\Cache\CacheKeys\StudentCacheKeys;

class TermlyRegistrationService extends ModelBaseService
{
    use EnsureCompanyIsSet;

    public function __construct(TermlyRegistration $model)
    {
        parent::__construct($model);
    }


    public function updateRegistration(TermlyRegistration $termlyRegistration, $data) : TermlyRegistration
    {
        $this->ensureCompanyIsSet();

        $request = (object) $data;

        $termlyRegistration->residence = $request->residence;
        $termlyRegistration->clazz_id = $request->clazz_id;
        $termlyRegistration->new_or_continuing = $request->new_or_continuing;
        $termlyRegistration->hostel_id = $request->hostel_id ?? null;
        $termlyRegistration->term_id = $request->term_id;

        $termlyRegistration->save();

        CacheKeys::clearRegistrationCache($termlyRegistration->id);
        Cachekeys::clearPaginatedRegistrationCache($termlyRegistration->company_id, $termlyRegistration->term_id, 15, 100);
        StudentCacheKeys::clearStudentProfileCache($termlyRegistration->company_id, $termlyRegistration->student_id);

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