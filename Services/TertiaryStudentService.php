<?php

namespace Modules\Schoolviser\Services;

use App\Traits\Repositories\EnsureCompanyIsSet;
use Illuminate\Validation\ValidationException;
use Modules\Schoolviser\Entities\TertiaryStudent;
use Modules\Schoolviser\Entities\IntakeRegistration;
use Modules\Schoolviser\Entities\Term;

use Illuminate\Support\Facades\Storage;
use Modules\Schoolviser\Cache\CacheKeys\TertiaryStudentCacheKeys;
use Modules\Schoolviser\Cache\CacheKeys\IntakeRegistrationCacheKeys;


class TertiaryStudentService
{
    use EnsureCompanyIsSet;

    protected Term $term;

    public function setTerm(Term $term)
    {
        $this->term = $term;
        return $this;
    }

    /**
     * Register a tertiary student into an intake.
     *
     * @param \Modules\Schoolviser\Entities\TertiaryStudent $student
     * @param object $data
     * @param int $companyId
     * @param callable|null $callback
     * @return \Modules\Schoolviser\Entities\IntakeRegistration
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(TertiaryStudent $student, object $data, callable $callback = null)
    {
        $this->ensureCompanyIsSet();

        // Check if already registered
        $exists = $student->intakeRegistrations()
            ->where('company_id', $this->companyId)
            ->where('term_id', $data->term_id)
            ->where('semester', $data->semester)
            ->where('year', $data->year)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'student' => 'This student is already enrolled in the selected intake.',
            ]);
        }

        // Create registration
        $registration = $student->intakeRegistrations()->create([
            'company_id'        => $this->companyId,
            'term_id'           => $data->term_id,
            'academic_year_id'  => $data->academic_year_id,
            'semester'          => $data->semester,
            'year'              => $data->year,
            'new_or_continuing' => $data->new_or_continuing,
        ]);

        // Run callback if provided
        if ($callback) {
            $callback($registration, $student);
        }

        IntakeRegistrationCacheKeys::clearPaginatedIntakeRegistrationsCachedData($this->companyId, $data->term_id, 15, 100);

        return $registration;
    }

    /**
     * Update personal information for a student.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Modules\Schoolviser\Entities\Student
     */
    public function updatePersonalInfo(TertiaryStudent $student, array $data, callable $callback = null)
    {
        $this->ensureCompanyIsSet();

        $student->first_name    = $data['first_name'] ?? $student->first_name;
        $student->last_name     = $data['last_name'] ?? $student->last_name;
        $student->gender        = $data['gender'] ?? $student->gender;
        $student->date_of_birth = $data['dob'] ?? $student->date_of_birth;
        $student->nationality   = $data['nationality'] ?? $student->nationality;
        $student->address       = $data['address'] ?? $student->address;
        $student->regno         = $data['regno'] ?? $student->regno;
        $student->phone         = $data['phone'] ?? $student->phone;
        $student->nin           = $data['nin'] ?? $student->nin;
        $student->city          = $data['city'] ?? $student->city;

        $student->save();

        // Clear cache
        TertiaryStudentCacheKeys::clearStudentProfileCachedData($this->companyId, $student->uuid);
        IntakeRegistrationCacheKeys::clearPaginatedIntakeRegistrationsCachedData($this->companyId, $data['term_id'] ?? 2, 15, 100);

        if ($callback) {
            $callback($student);
        }

        return $student;
    }

     public function updateAcademicInfo(TertiaryStudent $student, IntakeRegistration $registration, array $data, callable $callback = null)
    {
        $this->ensureCompanyIsSet();

        $registration->residence = $data['residence'] ?? $registration->residence;
        $registration->new_or_continuing = $data['new_or_continuing'] ?? $registration->new_or_continuing;
        $registration->year = $data['year'] ?? $registration->year;
        $registration->semester = $data['semester'] ?? $registration->semester;


        $student->course_id = $data['course'] ?? $studnet->course;
        $student->regno = $data['regno'] ?? $student->regno;
        $student->admission_number = $data['admission_number'] ?? $student->admission_number;

        $registration->save();
        $student->save();

        // Clear cache
        TertiaryStudentCacheKeys::clearStudentProfileCachedData($this->companyId, $student->uuid);
        IntakeRegistrationCacheKeys::clearPaginatedIntakeRegistrationsCachedData($this->companyId, $registration->term_id, 15, 100);
        IntakeRegistrationCacheKeys::clearIntakeRegistrationCachedData($this->companyId, $registration->uuid);

        if ($callback) {
            $callback($student, $registration);
        }

        return $student;
    }



    /**
     * Update a student's profile photo.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param callable|null $callback
     * @return \Modules\Schoolviser\Entities\Student
     */
    public function updatePhoto(TertiaryStudent $student, $photoFile, callable $callback = null)
    {
        $this->ensureCompanyIsSet();

        $company = company($this->companyId);

        // Build path: {delxero_account_number}/avatars/students/{student_id}.{ext}
        $directory = $company->delxero_account_number . '/avatars/students';
        $extension = $photoFile->getClientOriginalExtension(); // e.g. jpg, jpeg, png
        $filename  = $student->id . '.' . $extension;

        // Store file in public disk
        $path = $photoFile->storeAs($directory, $filename, 'public');

        // Update student record
        $student->photo = $path;
        $student->save();

        // Clear cache
        TertiaryStudentCacheKeys::clearCacheWithKeysEnding('PROFILE', [$this->companyId, $student->uuid]);
        if($this->term){
            IntakeRegistrationCacheKeys::clearPaginatedIntakeRegistrationsCachedData($this->companyId, $this->term->id, 15, 100);
        }

        // Run callback if provided
        if ($callback) {
            $callback($student, $path);
        }

        return $student;
    }


}
