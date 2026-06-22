<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


use Delgont\Core\Concerns\ModelHasMeta;


// Relation Models
//use App\Group;
//use App\Termination;
//use App\Hostel;
use App\Perent;

use Modules\Schoolviser\Entities\Term;
use Modules\Schoolviser\Entities\Course;

// Concerns
use Modules\Schoolviser\Concerns\Archivable;
use App\StudentPerent;
use Modules\Schoolviser\Concerns\Terminatable;

//use App\Models\Fee\Fee;
//use App\Models\Library\LibraryMember;


class Student extends Model
{
    use SoftDeletes, Archivable, ModelHasMeta, Terminatable;

    protected $guarded = []; // Allow mass assignment for all attributes

    // Append custom attributes to the JSON representation
    protected $appends = ['url', 'age'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }

            // Generate access number if not already set
            if (empty($model->access_number) && !empty($model->company_id)) {
                $model->access_number = self::generateAccessNumber($model->company_id);
            }

        });
    }

    /**
     * Accessor for age attribute
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->date_of_birth) {
            return null;
        }

        return Carbon::parse($this->date_of_birth)->age;
    }

    /**
     * Get the full name of the student.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucwords("{$this->surname} {$this->other_names}");
    }

    public function getPhotoAttribute()
    {
        return asset($this->photo ?? config('defaults.avator'));
    }

    /**
     * Get the URL for viewing the student.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return null;
        //return route('students.show', ['id' => $this->id]);
    }

    /**
     * Scope for filtering male students.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMale($query)
    {
        return $query->whereGender('male');
    }

    /**
     * Scope for filtering female students.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFemale($query)
    {
        return $query->whereGender('female');
    }

    /**
     * Scope for filtering students of a specific term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfTerm($query, $term)
    {
        return $query->whereHas('termlyRegistrations', function ($q) use ($term) {
            $q->where('term_id', $term);
        });
    }

    /**
     * Scope for filtering students of a specific year.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfYear($query, $year)
    {
        return $query->whereHas('termlyRegistrations', function ($q) use ($year) {
            $q->whereYear('created_at', $year);
        });
    }

    /**
     * Scope for filtering expelled students.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $year
     * @param int|null $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpelled($query, $year = null, $term = null)
    {
        return $query->whereHas('termination', function ($q) use ($year, $term) {
            $y = $year ?? option('current_year');
            $t = $term ?? option('current_term');
            $q->whereType('expelled')->where('year', $y)->whereTerm($t);
        });
    }

    /**
     * Scope for filtering currently enrolled students.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        return $query->whereHas('currentTermlyRegistration');
    }

    /**
     * Relationship for the student's current termly registration.
     */
    public function currentTermlyRegistration()
    {
        return $this->hasOne(TermlyRegistration::class)->whereHas('term', function ($termQuery) {
            $termQuery->current();
        });
    }

    /**
     * Relationship for the student's previous termly registration.
     */
    public function previousTermlyRegistration()
    {
        return $this->hasOne(TermlyRegistration::class)->whereHas('term', function ($termQuery) {
            $termQuery->previous();
        });
    }

    /**
     * Relationship for all termly registrations.
     */
    public function termlyRegistrations()
    {
        return $this->hasMany(TermlyRegistration::class);
    }

    /**
     * Relationship for all intake registrations.
     */
    public function intakeRegistrations()
    {
        return $this->hasMany(IntakeRegistration::class, 'student_id');
    }

    /**
     * Relationship for the current intake registration.
     */
    public function currentIntakeRegistration()
    {
        return $this->hasOne(IntakeRegistration::class)->whereHas('term', function ($termQuery) {
            $termQuery->current();
        });
    }

    /**
     * Relationship for the course the student belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Synchronize fees for the student.
     */
    public function syncFees()
    {
        $registrations = $this->termlyRegistrations()->with('term')->get();

        foreach ($registrations as $registration) {
            $registration->fees()->detach();
            $fees = Fee::whereTermId($registration->term->id)
                ->whereResidence($registration->residence)
                ->where('new_or_continuing', $registration->new_or_continuing)
                ->whereGender($registration->student->gender)
                ->where('clazz_id', $registration->clazz_id)
                ->get();

            foreach ($fees as $fee) {
                $registration->fees()->attach($fee->id);
            }
        }
    }

    /**
     * Generate a registration number for the student.
     */
    public function generateRegNo()
    {
        $this->regno = str_pad($this->id, 4, '0', STR_PAD_LEFT);
        $this->save();
    }

    /**
     * Relationship for the course group the student belongs to.
     */
    public function courseGroup()
    {
        return $this->belongsTo(CourseGroup::class);
    }

    /**
     * Relationship for the year group the student belongs to.
     */
    public function yearGroup()
    {
        return $this->belongsTo(YearGroup::class);
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
     * Fetch full details of the student including related models.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function fullDetails()
    {
        return $this->load(['course', 'courseGroup', 'yearGroup', 'currentIntakeRegistration']);
    }

     /**
     * Generate a unique access number scoped to a company.
     *
     * @param int $companyId
     * @return string
     */
    private static function generateAccessNumber(int $companyId): string
    {
        // Find the last access number for this company
        $lastAccessNumber = self::where('company_id', $companyId)
            ->whereNotNull('access_number')
            ->orderBy('access_number', 'desc')
            ->value('access_number');

        $counter = $lastAccessNumber
            ? (int) substr($lastAccessNumber, 1) // strip leading "A"
            : 0;

        $counter++;
        $accessNumber = sprintf('A%05d', $counter);

        // Ensure uniqueness
        while (self::where('company_id', $companyId)
                  ->where('access_number', $accessNumber)
                  ->exists()) {
            $counter++;
            $accessNumber = sprintf('A%05d', $counter);
        }

        return $accessNumber;
    }


    public function cohorts()
    {
        return $this->belongsToMany(Cohort::class, 'cohort_student')
            ->withPivot(['academic_year_id', 'assigned_on', 'removed_on', 'reason'])
            ->withTimestamps();
    }

    /**
     * Current active cohorts for this student
     */
    public function activeCohorts()
    {
        return $this->cohorts()->wherePivotNull('removed_on');
    }

    /**
     * Cohort history (including past moves)
     */
    public function cohortHistory()
    {
        return $this->cohorts()->orderByPivot('assigned_on', 'asc');
    }

    /**
     * Check if student is in a specific cohort
     */
    public function inCohort(Cohort $cohort): bool
    {
        return $this->activeCohorts()->where('cohort_id', $cohort->id)->exists();
    }

    /**
     * Register this student into a tertiary intake.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function registerTertiaryStudent(array $data, $companyId)
    {
        // Check if already registered in this intake
        $exists = $this->intakeRegistrations()
            ->where('company_id', $companyId)
            ->where('term_id', $data['term_id'])
            ->where('semester', $data['semester'])
            ->where('year', $data['year'])
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'student' => 'This student is already enrolled in the selected intake.',
            ]);
        }

        // Create registration
        return $this->intakeRegistrations()->create([
            'company_id'        => $companyId,
            'term_id'           => $data['term_id'],
            'academic_year_id'  => $data['academic_year_id'],
            'semester'          => $data['semester'],
            'year'              => $data['year'],
            'new_or_continuing' => $data['new_or_continuing'],
        ]);
    }
}

