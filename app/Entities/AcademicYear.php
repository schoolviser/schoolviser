<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

use Delgont\Core\Concerns\ModelHasMeta;


class AcademicYear extends Model
{
    use ModelHasMeta;

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
    
}
