<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Validation\ValidationException;

class TertiaryStudent extends Student
{
    protected $table = 'students';

    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Relationship for all intake registrations.
     */
    public function intakeRegistrations()
    {
        // Explicitly set foreign key to student_id
        return $this->hasMany(IntakeRegistration::class, 'student_id', 'id');
    }



    /**
     * Relationship for the current intake registration.
     */
    public function currentIntakeRegistration()
    {
        return $this->hasOne(IntakeRegistration::class, 'student_id', 'id')
            ->whereHas('term', function ($termQuery) {
                $termQuery->current();
            });
    }

    /**
     * Relationship for the course group the student belongs to.
     */
    public function courseGroup()
    {
        return $this->belongsTo(CourseGroup::class);
    }

    /**
     * Register this student into a tertiary intake using an object.
     *
     * @param object $data
     * @param int    $companyId
     * @throws \Illuminate\Validation\ValidationException
     */
    public function registerTertiaryStudent(object $data, int $companyId)
    {
        return $this->intakeRegistrations()->create([
            'company_id'        => $companyId,
            'term_id'           => $data->term_id,
            'academic_year_id'  => $data->academic_year_id,
            'semester'          => $data->semester,
            'year'              => $data->year,
            'new_or_continuing' => $data->new_or_continuing,
        ]);
    }

    /**
     * Lock all intake registrations for this student.
     */
    public function lockAllRegistrations(): void
    {
        // Fetch all intake registrations for this student
        $registrations = $this->intakeRegistrations()->get();

        foreach ($registrations as $registration) {
            $registration->lock();
        }
    }

    /**
     * Check if the student is currently enrolled.
     *
     * @return bool
     */
    public function isEnrolled()
    {
        return $this->currentTermlyRegistration()->exists();
    }

    
   
    /**
     * Relationship for the course the student belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
