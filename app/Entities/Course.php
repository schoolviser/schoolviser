<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Student\Entities\Student;
use Illuminate\Support\Str;

class Course extends Model
{

    protected $fillable = ['name', 'abbr'];

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

}
