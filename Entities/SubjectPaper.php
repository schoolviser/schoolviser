<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubjectPaper extends Model
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
     * A paper belongs to a subject.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Scope: compulsory papers.
     */
    public function scopeCompulsory($query)
    {
        return $query->where('compulsory', true);
    }

    /**
     * Scope: optional papers.
     */
    public function scopeOptional($query)
    {
        return $query->where('compulsory', false);
    }
}
