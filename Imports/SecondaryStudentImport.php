<?php
namespace Modules\Schoolviser\Imports;

use Modules\Schoolviser\Entities\SecondaryStudent;
use Modules\Schoolviser\Entities\TermlyRegistration;
use Modules\Schoolviser\Entities\Clazz;
use Modules\Schoolviser\Entities\Stream;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class SecondaryStudentImport implements ToModel, WithHeadingRow, OnEachRow
{
    protected $term;
    protected $companyId;
    protected static $ignored = [];
    protected static $imported = 0;

    protected $requiredColumns = [
        'first_name', 'last_name', 'gender', 'nationality', 'regno', 'clazz_name'
    ];

    public function __construct($term, $companyId)
    {
        $this->term = $term;
        $this->companyId = $companyId;
    }

    public function model(array $row)
    {
        // Clean up row values
        $cleanRow = array_map(function($value) {
            return is_string($value) ? trim($value) : $value;
        }, $row);

        // Skip completely empty rows (after trimming)
        if (empty(array_filter($cleanRow))) {
            return null;
        }

        // Check for missing required columns
        foreach ($this->requiredColumns as $col) {
            if (empty($row[$col])) {
                self::$ignored[] = [
                    'reason' => "Missing required column: {$col}",
                    'row'    => $row
                ];
                return null;
            }
        }


        // Resolve class
        $clazz = Clazz::where('name', $row['clazz_name'])->where('company_id', $this->companyId)->first();

        if (!$clazz) {
            self::$ignored[] = ['reason' => 'Invalid class', 'row' => $row];
            return null;
        }

        // Resolve stream and ensure it belongs to the class
        $stream = null;
        if (!empty($row['stream_name'])) {
            $stream = Stream::where('name', $row['stream_name'])
                ->where('clazz_id', $clazz->id)
                ->where('company_id', $this->companyId)
                ->first();

            if (!$stream) {
                self::$ignored[] = ['reason' => 'Stream does not belong to class', 'row' => $row];
                return null;
            }
        }

        // Check for duplicate regno
        $exists = SecondaryStudent::where('company_id', $this->companyId)
            ->where('regno', $row['regno'])
            ->exists();

        if ($exists) {
            self::$ignored[] = ['reason' => 'Duplicate regno', 'row' => $row];
            return null;
        }

        // Create student record
        $student = SecondaryStudent::create([
            'first_name'   => $row['first_name'],
            'last_name'    => $row['last_name'],
            'gender'       => $row['gender'],
            'nationality'  => $row['nationality'],
            'regno'        => $row['regno'],
            'company_id'   => $this->companyId,
        ]);

        self::$imported++;

        // Register student into current term
        return new TermlyRegistration([
            'student_id'       => $student->id,
            'term_id'          => $this->term->id,
            'clazz_id'         => $clazz->id,
            'stream_id'        => $stream?->id,
            'company_id'       => $this->companyId,
            'new_or_continuing'=> 'new',
        ]);
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();   // Excel row number
        $rowData  = $row->toArray();

        // Trim values
        $cleanRow = array_map(fn($v) => is_string($v) ? trim($v) : $v, $rowData);

        // Skip completely empty rows
        if (empty(array_filter($cleanRow))) {
            return null;
        }

        // Validate required columns
        foreach ($this->requiredColumns as $col) {
            if (empty($cleanRow[$col])) {
                self::$ignored[] = [
                    'reason' => "Row {$rowIndex}: Missing required column {$col}",
                    'row'    => $cleanRow
                ];
                return null;
            }
        }

        // … rest of your logic (class/stream validation, duplicate check, etc.)
    }

    public static function summary()
    {
        return [
            'imported' => self::$imported,
            'ignored'  => count(self::$ignored),
            'details'  => self::$ignored,
        ];
    }
}
