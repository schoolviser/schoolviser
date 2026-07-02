<?php
namespace Modules\Schoolviser\Services;

use Delgont\Core\Services\ModelService;

use Modules\Schoolviser\Entities\SecondaryStudent;
use Modules\Schoolviser\Entities\Term;

use Modules\Schoolviser\Cache\CacheKeys\SecondaryStudentCacheKeys;

use App\Traits\Repositories\EnsureCompanyIsSet;

class SecondaryStudentService extends ModelService
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440'; // Example: cache expiry in minutes
    protected $fromCache = false;    // Example: toggle to read from cache

    protected Term $term;

   

    public function __construct(SecondaryStudent $model)
    {
        parent::__construct($model);
    }

     public function setTerm(Term $term)
    {
        $this->term = $term;
        return $this;
    }


    public function updatePersonalInfo(SecondaryStudent $student, array $data) : SecondaryStudent
    {
        $this->ensureCompanyIsSet();

        $this->run('before', 'updatePersonalInfo', $student, $data);

        $student->fill([
            'first_name'   => $data['first_name'] ?? $student->first_name,
            'last_name'    => $data['last_name'] ?? $student->last_name,
            'gender'       => $data['gender'] ?? $student->gender,
            'date_of_birth'=> $data['dob'] ?? $student->date_of_birth,
            'nationality'  => $data['country'] ?? $student->nationality,
            'address'      => $data['address'] ?? $student->address,
            'regno'        => $data['regno'] ?? $student->regno,
            'phone'        => $data['phone'] ?? $student->phone,
            'nin'          => $data['nin'] ?? $student->nin,
            'city'         => $data['city'] ?? $student->city,
        ]);

        $student->save();

        $this->run('after', 'updatePersonalInfo', $student, $data);

        SecondaryStudentCacheKeys::clearCacheWithKeysStarting('STUDENT', [$this->companyId, $student->uuid]);

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
    public function updatePhoto(SecondaryStudent $student, $photoFile, callable $callback = null) : SecondaryStudent
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
        SecondaryStudentCacheKeys::clearCacheWithKeysEnding('PROFILE', [$this->companyId, $student->uuid]);
        if($this->term){
            //IntakeRegistrationCacheKeys::clearPaginatedIntakeRegistrationsCachedData($this->companyId, $this->term->id, 15, 100);
        }

        // Run callback if provided
        if ($callback) {
            $callback($student, $path);
        }

        return $student;
    }

    /**
     * Register a student for a given term, class, and stream.
     *
     * @param \Modules\Schoolviser\Entities\SecondaryStudent $student
     * @param array $data
     * @return \Modules\Schoolviser\Entities\TermlyRegistration
     */
    public function registerStudent(SecondaryStudent $student, array $data)
    {
        $this->ensureCompanyIsSet();

        $this->run('before', 'registerStudent', $student, $data);

        $registration = $student->termlyRegistrations()->create([
            'term_id'          => $data['term_id'],
            'clazz_id'         => $data['clazz_id'],
            'stream_id'        => $data['stream_id'] ?? null,
            'student_id'       => $student->id,
            'company_id'       => $this->companyId,
            'new_or_continuing'=> $data['new_or_continuing'] ?? 'new',
        ]);

        $this->run('after', 'registerStudent', $student, $registration);

        SecondaryStudentCacheKeys::clearCacheWithKeysStarting('STUDENT', [$this->companyId, $student->uuid]);
        SecondaryStudentCacheKeys::clearTermPaginatedCachedData($this->companyId, $data['term_id'], 15, 250);

        return $registration;
    }


    
    
}
