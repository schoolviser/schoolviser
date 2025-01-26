<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student;

class CourseGroup extends Model
{
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereActive('1');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
