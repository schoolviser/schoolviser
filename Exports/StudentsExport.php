<?php

namespace Modules\Schoolviser\Exports;

use App\Models\Company;
use Modules\Schoolviser\Entities\Term;
use Modules\Schoolviser\Entities\Course;
use Modules\Schoolviser\Entities\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected Company $company;
    protected Term $term;
    protected ?Course $course;
    protected ?string $gender;

    public function __construct(Company $company, Term $term, Course $course = null, $gender = null)
    {
        $this->company = $company;
        $this->term = $term;
        $this->course = $course;
        $this->gender = $gender;
    }


    public function collection()
    {
        $students = Student::with('course')
            ->whereCompanyId($this->company->id)
            ->whereHas('intakeRegistrations', function ($query) {
                $query->whereTermId($this->term->id)
                      ->whereCompanyId($this->company->id);
            })
            ->when($this->course, function ($query) {
                $query->whereHas('course', function ($courseQuery) {
                    $courseQuery->where('id', $this->course->id);
                });
            })
            ->when($this->gender, function ($query) {
                $query->where('gender', $this->gender);
            })
            ->get([
                'regno',
                'admission_number',
                'access_number',
                'first_name',
                'last_name',
                'gender',
                'email',
                'course_id'
            ]);

        // Map to include course name
        return $students->map(function ($student) {
            return [
                'Reg No'            => $student->regno,
                'Admission Number'  => $student->admission_number,
                'Access Number'     => $student->access_number,
                'First Name'        => $student->first_name,
                'Last Name'         => $student->last_name,
                'Gender'            => $student->gender,
                'Email'             => $student->email,
                'Course'            => optional($student->course)->name, // safe access
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Reg No',
            'Admission Number',
            'Access Number',
            'First Name',
            'Last Name',
            'Gender',
            'Email',
            'Course',
        ];
    }

    
}
