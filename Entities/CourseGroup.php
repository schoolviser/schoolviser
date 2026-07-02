<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class CourseGroup extends Model
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
        return $this->hasMany(TertiaryStudent::class);
    }
}
