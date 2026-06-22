<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseGroup extends Model
{
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereActive('1');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
