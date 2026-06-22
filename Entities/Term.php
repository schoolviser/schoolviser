<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

use Delgont\Core\Concerns\ModelHasMeta;




use Modules\Schoolviser\Entities\TermlyRegistration;
use Modules\Schoolviser\Entities\IntakeRegistration;


class Term extends Model
{
    use ModelHasMeta;

    protected $guarded = [];
    protected $with = ['academicYear'];


    //Term cache prefix
    public static $cachePrefix = 'Term';
    protected $appends = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }


    public function getNameAttribute(): string
    {
        $label = config('schoolviser.intakes')[$this->term] ?? null;
        return $label ?? "Term {$this->term} ({$this->year})";
}

    public function scopeActive($query)
    {
        return $query->whereStatus('active');
    }


    //Get the current term session
    public function scopeCurrent($query)
    {
        return $query->where('start_date', '<=', Carbon::today())->where('end_date', '>=', Carbon::today());
    }

    //Get the preious session
    public function scopePrevious($query, $current = null)
    {
        $current = ($current) ? $current : $this->current()->first();
        return $query->where('end_date', '<=', $current->start_date);
    }

    //Get the next session
    public function scopeNext($query, $current = null)
    {
        $current = ($current) ? $current : $this->current()->first();
        return $query->where('start_date', '>=', $current->end_date);
    }

    //Get the last available session
    public function scopeLast($query){
        return $query->where('end_date', '<=', Carbon::today());
    }

    public function termlyRegistrations()
    {
        return $this->hasMany(TermlyRegistration::class, 'term_id');
    }

    public function intakeRegistrations()
    {
        return $this->hasMany(IntakeRegistration::class, 'term_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

}
