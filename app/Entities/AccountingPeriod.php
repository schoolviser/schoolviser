<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Delgont\Core\Concerns\ModelHasMeta;


class AccountingPeriod extends Model
{
    use ModelHasMeta;

    protected $casts = [
        'is_current' => 'boolean'
    ];

    //Get the current accounting period
    public function scopeCurrent($query)
    {
        return $query->where('start_date', '<=', Carbon::today())->where('end_date', '>=', Carbon::today());
    }

    public function scopePrevious($query, $current = null)
    {
        $current = ($current) ? $current : $this->current()->first();
        return $query->where('end_date', '<=', $current->start_date);
    }

    public function scopeNext($query, $current = null)
    {
        $current = ($current) ? $current : $this->current()->first();
        return $query->where('start_date', '>=', $current->end_date);
    }

    public function budgetingSettings()
    {
        return $this->options()->whereGroup('budgeting_settings');
    }


}
