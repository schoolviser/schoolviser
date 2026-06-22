<?php

namespace Modules\Schoolviser\Services;

use App\Services\ModelBaseService;
use App\Traits\Repositories\EnsureCompanyIsSet;
use Modules\Schoolviser\Entities\AcademicYear;

class AcademicYearService extends ModelBaseService
{
    use EnsureCompanyIsSet;

    public function __construct(AcademicYear $model)
    {
        parent::__construct($model);
    }

    /**
     * Check if given dates overlap with any existing year for this company.
     */
    public function checkIfDatesOverLapExisting($start_date, $end_date): bool
    {
        $this->ensureCompanyIsSet();

        return $this->model
            ->whereCompanyId($this->companyId)
            ->where(function ($query) use ($start_date, $end_date) {
                // Overlap if start <= new end AND end >= new start
                $query->where('start_date', '<=', $end_date)
                      ->where('end_date', '>=', $start_date);
            })
            ->exists();
    }

    /**
     * Create a new academic year record for this company.
     */
    public function createYear($data): AcademicYear
    {
        $this->ensureCompanyIsSet();

        // Cast to array to avoid object property issues
        $payload = (object) $data;

        $year = new $this->model;
        $year->name       = $payload?->name;
        $year->start_date = $payload?->start_date;
        $year->end_date   = $payload?->end_date;
        $year->company_id = $this->companyId;

        $year->save();

        return $year;
    }
}