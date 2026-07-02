<?php

namespace Modules\Schoolviser\Entities\Traits;

use Modules\Schoolviser\Entities\Combination;
use Modules\Schoolviser\Entities\StudentCombination;

trait StudentHasCombination
{
    /**
     * Current combination (direct field on students table).
     */
    public function currentCombination()
    {
        return $this->belongsTo(Combination::class, 'combination_id');
    }

    /**
     * Historical combinations across terms/years.
     */
    public function combinationHistory()
    {
        return $this->hasMany(StudentCombination::class);
    }

    /**
     * Assign a new combination for a given term/year.
     *
     * @param int $combinationId
     * @param int $clazzId
     * @param int $termId
     * @param int $academicYearId
     * @return \Modules\Schoolviser\Entities\StudentCombination
     */
    public function assignCombination($combinationId, $clazzId, $termId, $academicYearId)
    {
        // Update current combination on student record
        $this->update(['combination_id' => $combinationId]);

        // Record history in student_combinations table
        return $this->combinationHistory()->create([
            'combination_id'   => $combinationId,
            'clazz_id'         => $clazzId,
            'term_id'          => $termId,
            'academic_year_id' => $academicYearId,
            'company_id'       => $this->company_id,
        ]);
    }

    /**
     * Helper: check if student has ever changed combination.
     */
    public function hasChangedCombination()
    {
        return $this->combinationHistory()->count() > 1;
    }

    /**
     * Helper: get the latest combination record.
     */
    public function latestCombinationRecord()
    {
        return $this->combinationHistory()->latest()->first();
    }
}
