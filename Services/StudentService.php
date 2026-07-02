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

namespace Modules\Schoolviser\Services;

use Delgont\Core\Services\ModelService;

use App\Traits\Repositories\EnsureCompanyIsSet;
use Illuminate\Support\Facades\DB;
use Modules\Schoolviser\Entities\Student;
use Modules\Schoolviser\Entities\TermlyRegistration;

use Modules\Schoolviser\Cache\CacheKeys\StudentCacheKeys as CacheKeys;


class StudentService extends ModelService
{
    use EnsureCompanyIsSet;

    public function __construct(Student $model)
    {
        parent::__construct($model);
    }

    public function createStudent($data)
    {
        $this->ensureCompanyIsSet();
        $data = (object)$data;

        return DB::transaction(function () use ($data) {
            // Create student
            $student = new $this->model;
            $student->regno        = $data->regno ?? null;
            $student->first_name   = $data->first_name;
            $student->last_name    = $data->last_name;
            $student->gender       = $data->gender ?? null;
            $student->nationality  = $data->country ?? null;
            $student->date_of_birth          = $data->dob;
            $student->year_group_id = $data->year_group ?? null;
            $student->company_id = $this->companyId;
            $student->save();

            // Register student for term
            $registration = new TermlyRegistration;
            $registration->term_id          = $data->term_id; // safer than calling term()->id directly
            $registration->student_id       = $student->id;
            $registration->clazz_id         = $data->clazz_id;
            $registration->residence        = $data->residence;
            $registration->new_or_continuing = $data->new_or_continuing ?? 'continuing';
            $registration->hostel_id        = $data->hostel_id ?? null;
            $registration->company_id = $this->companyId;

            $registration->save();

            return (object)[
                'student'      => $student,
                'registration' => $registration,
            ];
        });
    }

    public function updatePersonalInfo(Student $student, $data) : Student
    {
        $this->ensureCompanyIsSet();

        $request = (object)$data;

        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->date_of_birth = $request->dob;
        $student->nationality = $request->country;
        $student->address = $request->address;
        $student->regno = $request->regno;
        $student->phone = $request->phone;
        $student->nin = $request->nin;
        $student->city = $request->city;

        $student->save();

        CacheKeys::clearStudentProfileCache($student->company_id, $student->id);
        return $student;
    }

   
}