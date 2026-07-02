<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Schoolviser\Concerns\Termable;
use Illuminate\Support\Str;

class IntakeRegistration extends Model
{
    use Termable;

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
        return $this->belongsTo(TertiaryStudent::class, 'student_id', 'id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'termly_registration_fees')
                    ->using(TermlyRegistrationFee::class)
                    ->withPivot(['discount','discount_reason','discount_format']);
    }

    /**
     * Lock this registration to prevent changes.
     */
    public function lock(): void
    {
        $this->locked = true;
        $this->save();
    }

    /**
     * Unlock this registration to allow changes.
     */
    public function unlock(): void
    {
        $this->locked = false;
        $this->save();
    }

    /**
     * Check if registration is locked.
     */
    public function isLocked(): bool
    {
        return (bool) $this->locked;
    }
}
