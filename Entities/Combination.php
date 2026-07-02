<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Combination extends Model
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'combination_subjects');
    }

    public function subsidiary1()
    {
        return $this->belongsTo(Subject::class, 'subsidiary1_id');
    }

    public function subsidiary2()
    {
        return $this->belongsTo(Subject::class, 'subsidiary2_id');
    }

    public function subsidiary3()
    {
        return $this->belongsTo(Subject::class, 'subsidiary3_id');
    }

    /**
     * Helper: get all subsidiary subjects.
     */
    public function subsidiaries()
    {
        return collect([$this->subsidiary1, $this->subsidiary2, $this->subsidiary3])->filter();
    }
}
