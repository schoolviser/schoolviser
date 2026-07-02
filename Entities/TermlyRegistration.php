<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use Modules\Schoolviser\Concerns\Termable;

//use Modules\Fee\Entities\Fee;

//use Modules\Fee\Entities\IndividualFee;
//use Modules\Fee\Entities\FeeDiscount;
//use Modules\Fee\Entities\FeePayment;
//use Modules\Fee\Entities\PreviousBalance;

//use Modules\Fee\Entities\TermlyRegistrationFee;

//use Modules\Fee\Entities\TermlyRegistrationFeeDiscount;



class TermlyRegistration extends Model
{
    use SoftDeletes, Termable;
    
    protected $guarded = [];
    protected $with = ['clazz','term.academicYear'];


    public static $cachePrefix = 'TermlyRegistration';

     /**
     * The name of the "term id" column.
     *
     * @var string|null
     */
    const TERM_ID = 'term_id';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
    
    public function scopeOf($query, $term)
    {
        return $query->whereTermId($term->id)->whereHas('student', function($studentQuery){
            $studentQuery->whereNull('deleted_at')->whereNull('archived_at');
        });
    }

    //Get student registrations of specific year
    public function scopeOfYear($query, $year)
    {
        return $query->where('year', $year)->whereHas('student', function($query){
            $query->whereNull('deleted_at')->whereNull('archived_at');
        });
    }

    /**
     * Get registrattions of specific clazz
     */
    public function scopeOfClazz($query, $clazz)
    {
        return $query->whereHas('clazz', function($clazzQuery) use($clazz){
            (is_int($clazz)) ? $clazzQuery->whereId($clazz) : $clazzQuery->where('name', $clazz);
        });
    }


    public function clazz()
    {
        return $this->belongsTo(Clazz::class, 'clazz_id');
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class, 'hostel_id');
    }

    //Get students who are in borading
    public function scopeBoarding($query)
    {
        return $query->whereResidence('boarding');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


    //Get the fees which the student is suppose to pay that term
    public function fees()
    {
         return $this->belongsToMany(Fee::class, 'termly_registration_fees')->using(TermlyRegistrationFee::class)->withPivot(['discount','discount_reason','discount_format']);
    }

    public function requirements()
    {
         return $this->belongsToMany(Requirement::class, 'termly_registration_requirements')->using(TermlyRegistrationRequirement::class);
    }

    public function previousBalance()
    {
        return $this->hasOne(PreviousBalance::class)->whereType('termly');
    }

    public function startPreviousBalance()
    {
        return $this->hasOne(PreviousBalance::class)->whereType('start');
    }


    //Get student termly individual fee
    public function individualFees()
    {
        return $this->hasMany(IndividualFee::class, 'termly_registration_id');
    }

     //Get student termly fees
     public function fines()
     {
          return $this->hasMany(IndividualFee::class, 'termly_registration_id')->where('type', 'fine');
     }

    public function feeDiscounts()
    {
     return $this->hasMany(FeeDiscount::class);
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class, 'termly_registration_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class, 'stream_id');
    }

}
