<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Modules\Student\Entities\TermlyRegistration;

use Delgont\Core\Concerns\ModelHasMeta;

class Term extends Model
{
    use ModelHasMeta;
    
    protected $guarded = [];



    //Term cache prefix
    public static $cachePrefix = 'Term';

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

}
