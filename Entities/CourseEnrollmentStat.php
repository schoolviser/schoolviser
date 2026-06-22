<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseEnrollmentStat extends Model
{
    protected $guarded = [];

    /**
     * Each stat belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Each stat belongs to a term.
     */
    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Each stat belongs to an academic year.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Each stat belongs to a company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
