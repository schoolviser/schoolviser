<?php
namespace Modules\Schoolviser\Exports;

use Modules\Schoolviser\Entities\Clazz;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SecondaryStudentTemplateExport implements WithMultipleSheets
{
    protected $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    public function sheets(): array
    {
        return [
            new StudentSheet(),
            new ReferenceSheet($this->companyId),
        ];
    }
}

class StudentSheet implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings
{
    public function collection()
    {
        return new Collection([]); // empty rows, just structure
    }

    public function headings(): array
    {
        return [
            'first_name',
            'last_name',
            'gender',
            'dob',
            'nationality',
            'regno',
            'clazz_name',
            'stream_name',
        ];
    }
}

class ReferenceSheet implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings
{
    protected $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    public function collection()
    {
        $rows = [];
        $clazzes = Clazz::where('company_id', $this->companyId)
            ->with('streams')
            ->get();

        foreach ($clazzes as $clazz) {
            foreach ($clazz->streams as $stream) {
                $rows[] = [
                    'Class'  => $clazz->name,
                    'Stream' => $stream->name,
                ];
            }
        }

        return new Collection($rows);
    }

    public function headings(): array
    {
        return ['Class', 'Stream'];
    }
}
