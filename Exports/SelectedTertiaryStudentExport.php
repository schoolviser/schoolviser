<?php

namespace Modules\Schoolviser\Exports;

use Modules\Schoolviser\Entities\TertiaryStudent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SelectedTertiaryStudentExport implements FromCollection, WithHeadings
{
    protected array $studentIds;

    public function __construct(array $studentIds)
    {
        $this->studentIds = $studentIds;
    }

    public function collection()
    {
        $students = TertiaryStudent::with('course')
            ->whereIn('id', $this->studentIds)
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

        return $students->map(function ($student) {
            return [
                'Reg No'            => $student->regno,
                'Admission Number'  => $student->admission_number,
                'Access Number'     => $student->access_number,
                'First Name'        => $student->first_name,
                'Last Name'         => $student->last_name,
                'Gender'            => $student->gender,
                'Email'             => $student->email,
                'Course'            => optional($student->course)->name,
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
