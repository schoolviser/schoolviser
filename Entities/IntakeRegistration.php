<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Modules\Schoolviser\Concerns\Termable;
//use Modules\Fee\Entities\TermlyRegistrationFee;
//use Modules\Fee\Entities\Fee;

use Illuminate\Support\Str;


class IntakeRegistration extends Model
{
    use SoftDeletes, Termable;

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



    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    //Get the fees which the student is suppose to pay that term
    public function fees()
    {
         return $this->belongsToMany(Fee::class, 'termly_registration_fees')->using(TermlyRegistrationFee::class)->withPivot(['discount','discount_reason','discount_format']);
    }
}
