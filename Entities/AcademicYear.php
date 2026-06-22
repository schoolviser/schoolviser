<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

use Carbon\Carbon;

use Delgont\Core\Concerns\ModelHasMeta;

class AcademicYear extends Model
{
    use ModelHasMeta;

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
     * Get The Current Academic Year
     */
    public function scopeCurrent($query)
    {
        return $query->where('start_date', '<=', Carbon::today())->where('end_date', '>=', Carbon::today());
    }

    /**
     * Get The Previous Academic Year
     */
    public function scopePrevious($query, $current = null)
    {
        $current = ($current) ? $current : $this->current()->first();
        return $query->where('end_date', '<=', $current->start_date);
    }

    /**
     * Get The Next Academic Year
     */
    public function scopeNext($query, $current = null)
    {
        $current = ($current) ? $current : $this->current()->first();
        return $query->where('start_date', '>=', $current->end_date);
    }

    public function terms()
    {
        return $this->hasMany(Term::class);
    }
    
}
