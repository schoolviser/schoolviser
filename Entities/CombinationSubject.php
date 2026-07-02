<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CombinationSubject extends Model
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

    public function combination()
    {
        return $this->belongsTo(Combination::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
