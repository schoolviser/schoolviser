<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;

class MonthlyExpenseSummaryCacheManager
{
    const CACHE_PREFIX = 'monthlyExpenseSummary';

    protected $term;
    //

    /**
     * Current term
     */
    public function current()
    {
        $this->term = term();
        return $this;
    }

    public function ofTerm($term)
    {
        $this->term = (is_int($term)) ? term($term) : $term;
        return $this;
    }

    /**
     * Clear cache
     */

     public function clear()
     {
        return true;
     }

     public static function clearCurrentTermExpenseSummaryFromCache()
     {
        Cache::forget(self::CACHE_PREFIX.':'.term()->id);
     }
}
