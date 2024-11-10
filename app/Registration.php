<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Student;
use App\Clazz;
use App\Term;
use App\Semester;

class Registration extends Model
{
    //

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->with = [$this->clazzORCourse()] ;
    }


    //Get the curent student registrations
    public function scopeCurrent($query)
    {
        return $query->where('year', option('current_year'))->whereHas('student', function($query){
            $query->whereNull('deleted_at')->whereNull('archived_at');
        })->whereHas('currentTerm')->with(['student']);
    }

    public function scopeOf($query, $year, $term)
    {
        return $query->where('year', $year)->whereHas('student', function($query){
            $query->whereNull('deleted_at')->whereNull('archived_at');
        })->whereHas('terms', function($query) use ($term){
            $query->where('term', $term);
        });
    }

    //Get student registrations of specific year
    public function scopeOfYear($query, $year)
    {
        return $query->where('year', $year)->whereHas('student', function($query){
            $query->whereNull('deleted_at')->whereNull('archived_at');
        });
    }

    public function scopeOfClazz($query, $name)
    {
        return $query->whereHas('clazz', function($q) use($name){
            $q->where('name', $name);
        });
    }

    //Get student registrations of the specific term
    public function scopeOfTerm($query, $term)
    {
        return $this->where('term', $term)->whereHas('student', function($query){
            $query->whereNull('deleted_at')->whereNull('archived_at');
        });
    }

    


    public function getResidenceAttribute($value)
    {
        return ($value == 'B') ? 'Boarding' : 'Day';
    }


    
    public function clazz()
    {
        return $this->belongsTo(Clazz::class, 'clazz_id');
    }

    public function terms()
    {
        return $this->hasMany(Term::class);
    }

    public function currentTerm()
    {
        return $this->hasOne(Term::class)->where('term', option('current_term'));
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function currentSemester()
    {
        return $this->hasOne(Semester::class)->where('semester', option('current_semester'));
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id')->withTrashed();
    }


    private function clazzORCourse()
    {
        return $clazz_or_course = (config('defaults.school_type') == 'tertiary') ? 'course' : 'clazz';
    }

    private function termOrSemester()
    {
        return $term_or_semester = (config('defaults.school_type') == 'tertiary') ? 'semesters' : 'term';
    }

    private function currentTermOrSemester()
    {
        return $term_or_semester = (config('defaults.school_type') == 'tertiary') ? 'currentSemester' : 'currentTerm';
    }

}
