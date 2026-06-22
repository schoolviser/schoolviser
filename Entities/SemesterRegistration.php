<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Concerns\Termable;


class SemesterRegistration extends Model
{
    use SoftDeletes, Termable;

    protected $guarded = [];


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

}
