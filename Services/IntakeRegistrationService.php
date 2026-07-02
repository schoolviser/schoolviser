<?php

namespace Modules\Schoolviser\Services;

use App\Services\ModelBaseService;
use App\Traits\Repositories\EnsureCompanyIsSet;
use Modules\Schoolviser\Entities\IntakeRegistration;

use Modules\Schoolviser\Cache\CacheKeys\TertiaryStudentCacheKeys;
use Modules\Schoolviser\Cache\CacheKeys\IntakeRegistrationCacheKeys;

class IntakeRegistrationService extends ModelBaseService
{
    use EnsureCompanyIsSet;

    protected $studentIds;

    public function __construct(IntakeRegistration $model)
    {
        parent::__construct($model);
    }

    public function setStudentIds(array $ids)
    {
        $this->studentIds = $ids;
        return $this;
    }

    /**
     * Lock a registration to prevent edits.
     */
    public function lockRegistration(IntakeRegistration $intakeRegistration, callable $callback = null): void
    {
        $this->ensureCompanyIsSet();

        $intakeRegistration->lock();

        if (!empty($this->studentIds)) {
            TertiaryStudentCacheKeys::clearStudentProfileCachedData($this->companyId, $this->studentIds);
        } else {
            TertiaryStudentCacheKeys::clearStudentProfileCachedData($this->companyId, $intakeRegistration->student_id);
        }
        IntakeRegistrationCacheKeys::clearIntakeRegistrationCachedData($this->companyId, [$intakeRegistration->id, $intakeRegistration->uuid]);

        if ($callback) {
            $callback($intakeRegistration);
        }
    }

    /**
     * Lock a registration to prevent edits.
     */
    public function unLockRegistration(IntakeRegistration $intakeRegistration, callable $callback = null): void
    {
        $this->ensureCompanyIsSet();

        $intakeRegistration->unlock();

        if (!empty($this->studentIds)) {
            TertiaryStudentCacheKeys::clearStudentProfileCachedData($this->companyId, $this->studentIds);
        } else {
            TertiaryStudentCacheKeys::clearStudentProfileCachedData($this->companyId, $intakeRegistration->student_id);
        }
        IntakeRegistrationCacheKeys::clearIntakeRegistrationCachedData($this->companyId, [$intakeRegistration->id, $intakeRegistration->uuid]);

        if ($callback) {
            $callback($intakeRegistration);
        }
    }

    /**
     * Check if a registration is locked.
     */
    public function isLocked(IntakeRegistration $intakeRegistration): bool
    {
        return $intakeRegistration->isLocked();
    }

    /**
     * UNDER_REVIEW
     * 
     * Bulk lock multiple registrations.
     *
     * @param \Illuminate\Support\Collection|array $registrations
     */
    public function bulkLockRegistrations($registrations, callable $callback = null): void
    {
        $this->ensureCompanyIsSet();

        foreach ($registrations as $registration) {
            $registration->lock();

            TertiaryStudentCacheKeys::clearStudentProfileCacheData($this->companyId, $registration->student_id);

            if ($callback) {
                $callback($registration);
            }
        }
    }
}
