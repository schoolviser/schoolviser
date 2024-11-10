<?php

namespace App\Entities\Concerns;

use Illuminate\Database\Eloquent\Model;

use App\Models\Accounting\AccountingPeriod;

trait BelongsToAccountingPeriod
{
 
  /**
     * Accounting Period -> Finacial year
     */
    public function period()
    {
        return $this->belongsTo(AccountingPeriod::class, 'accounting_period_id');
    }

    public function scopeOfPeriod($query, $period)
    {
        return $query->whereHas('period', function($periodQuery) use ($period){
            (is_int($period)) ?  $periodQuery->whereId($period) : $periodQuery->whereId($period->id);
        });
    }
 
}