<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Cohort extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'short_code',
        'description',
        'company_id',
        'course_id',
        'academic_year_id',
        'active',
        'starts_on',
        'ends_on',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Company relationship
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    /**
     * Course relationship
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Academic year relationship
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Students in this cohort (with pivot data for history)
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'cohort_student')
            ->withPivot(['academic_year_id', 'assigned_on', 'removed_on', 'reason'])
            ->withTimestamps();
    }

    /**
     * Helper: Get currently active students
     */
    public function activeStudents()
    {
        return $this->students()->wherePivotNull('removed_on');
    }

    /**
     * Helper: Assign a student to this cohort
     */
    public function assignStudent(Student $student, ?int $academicYearId = null, ?string $reason = null): void
    {
        $this->students()->attach($student->id, [
            'academic_year_id' => $academicYearId,
            'assigned_on'      => now(),
            'reason'           => $reason,
        ]);
    }

    /**
     * Helper: Remove a student from this cohort (preserve history)
     */
    public function removeStudent(Student $student, ?string $reason = null): void
    {
        $this->students()->updateExistingPivot($student->id, [
            'removed_on' => now(),
            'reason'     => $reason,
        ]);
    }

    /**
     * Helper: Check if a student is currently in this cohort
     */
    public function hasStudent(Student $student): bool
    {
        return $this->activeStudents()->where('student_id', $student->id)->exists();
    }
}