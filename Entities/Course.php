<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Modules\Schoolviser\Entities\Student;
//use Modules\Fee\Entities\Fee;


class Course extends Model
{

    protected $guarded = [];

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
     * Get the department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'course_id');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

}
