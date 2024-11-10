<?php

namespace App\Entities\Concerns;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Entities\AccountingPeriod;
use App\Entities\Term;

trait Periodic
{

  protected $default_period = 'accounting_period';
 
  /**
   * Get current period expense transactions
   */
  public function scopeCurrent($query, $period = 'accounting_period')
  {
    if($period == 'term'){
      return $query->whereHas('term', function($termQuery){
        $termQuery->current();
      });
    }
      return $query->whereHas('accountingPeriod', function($accountingPeriodQuery){
          $accountingPeriodQuery->current();
      });
  }

  /**
   * Get current period expense transactions
   */
  public function scopePrevious($query, $period = 'accounting_period')
  {
    if($period == 'term'){
      return $query->whereHas('term', function($termQuery){
        $termQuery->previous();
      });
    }
      return $query->whereHas('accountingPeriod', function($accountingPeriodQuery){
          $accountingPeriodQuery->previous();
      });
  }

  /**
   * Off specific period term or accounting period
   */
  public function scopePeriod($query, $period_id, $period = 'accounting_period')
  {
    if($period == 'term'){
      return $query->whereHas('term', function($termQuery) use($period_id){
        $termQuery->whereId($period_id);
      });
    }
      return $query->whereHas('accountingPeriod', function($accountingPeriodQuery) use ($period_id){
          $accountingPeriodQuery->whereId($period_id);
      });
  }
  
  public function accountingPeriod()
  {
     return $this->belongsTo(AccountingPeriod::class, 'accounting_period_id');
  }

  public function term()
  {
      return $this->belongsTo(Term::class, 'term_id');
  }

}