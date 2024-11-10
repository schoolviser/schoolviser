<?php

namespace App\Exports;

use App\Models\TermlyRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Support\Models\Any;


class StudentsExport implements FromCollection, WithHeadings
{
    public $year;
    public $term;
    public $class;

    public function __construct($year, $term, $class = null)
    {
        $this->year = $year;
        $this->term = $term;
        $this->class = $class;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $registrations = TermlyRegistration::of($this->year, $this->term)->with(['student'])->get();

        return collect($registrations)->map(function($item, $key){
            return new Any([
                'new_or_continuing' => $item->new_or_continuing,
                'regno' => $item->regno,
                'names' => $item->student->surname.' '.$item->student->other_names,
                'gender' => $item->student->gender,
                'dob' => $item->student->dob,
                'class' => $item->clazz->abbr,
                'section' => $item->residence,
            ]);
        });
    }

    public function headings(): array
    {
        return [
            'Old Or New',
            'Regno',
            'Student Names',
            'Gender',
            'Date Of Birth',
            'Class',
            'Section'
        ];
    }
}
