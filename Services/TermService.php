<?php

namespace Modules\Schoolviser\Services;

use App\Services\ModelBaseService;
use App\Traits\Repositories\EnsureCompanyIsSet;
use Modules\Schoolviser\Entities\Term;
use Modules\Schoolviser\Cache\CacheKeys\TermCacheKeys as CacheKeys;

class TermService extends ModelBaseService
{
    use EnsureCompanyIsSet;

    public function __construct(Term $model)
    {
        parent::__construct($model);
    }

    public function createTerm($data): Term
    {
        $this->ensureCompanyIsSet();

        $data = (object) $data;

        $term = new $this->model;

        $term->academic_year_id = $data->year_id;
        $term->term             = $data->term;
        $term->start_date       = $data->start_date;
        $term->end_date         = $data->end_date;
        $term->company_id       = $this->companyId;

        $term->save();

        CacheKeys::clearTermsCache($this->companyId);

        return $term;
    }

     /**
     * Update an existing term.
     */
    public function updateTerm(Term $term, $data): Term
    {
        $this->ensureCompanyIsSet();

        $data = (object) $data;

        $term->academic_year_id = $data->year_id;
        $term->term             = $data->term;
        $term->start_date       = $data->start_date;
        $term->end_date         = $data->end_date;
        $term->company_id       = $this->companyId;

        $term->save();

        CacheKeys::clearTermsCache($this->companyId);

        return $term;
    }

    /**
     * Check if given dates overlap with any existing term for this company.
     * Optionally ignore a specific term ID (useful when updating).
     */
    public function checkIfDatesOverLapExisting($start_date, $end_date, $ignoreId = null): bool
    {
        $this->ensureCompanyIsSet();

        return $this->model
            ->whereCompanyId($this->companyId)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where(function ($query) use ($start_date, $end_date) {
                // Overlap if start <= new end AND end >= new start
                $query->where('start_date', '<=', $end_date)
                      ->where('end_date', '>=', $start_date);
            })
            ->exists();
    }

    /**
     * Delete a term only if it has no dependent relations.
     */
    public function deleteTerm(Term $term): bool
    {
        $this->ensureCompanyIsSet();

        // Example relation: termlyRegistrations
        if ($term->termlyRegistrations()->exists()) {
            return false; // cannot delete
        }

        $term->delete();

        CacheKeys::clearTermsCache($this->companyId);

        return true;
    }

}