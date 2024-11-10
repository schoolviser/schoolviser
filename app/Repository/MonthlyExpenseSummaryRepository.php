<?php

namespace App\Repository;

use App\Models\Accounting\Expense\MonthlyExpenseSummary;

use Illuminate\Support\Collection;
use App\Cache\MonthlyExpenseSummaryCacheManager;
use Illuminate\Support\Facades\Cache;

class MonthlyExpenseSummaryRepository
{
    protected $fromCache;
    protected $term;
    protected $cacheManager;

    protected $cacheExpiry = '1440';

    public function __construct(MonthlyExpenseSummaryCacheManager $cachedMonthlyExpenseSummary)
    {
        $this->cacheManager = $cachedMonthlyExpenseSummary;
    }

    public function fromCache()
    {
        $this->fromCache = true;
        return $this;
    }

    /**
     * Get current term monthly expense
     */
    public function current()
    {
        $this->term = term();
        return $this;
    }

    /**
     * Get summary of specified period
     */
    public function period($term_id)
    {
        $this->term = term($term_id);
        return $this->id;
    }

    public function get()
    {
        if($this->fromCache){
            $cachedMonthlyExpenseSummary = Cache::get($this->cacheManager::CACHE_PREFIX.':'.$this->term->id);
            if($cachedMonthlyExpenseSummary){
                return $cachedMonthlyExpenseSummary;
            }
            $monthlyExpenses = $this->getMonthlyExpenseSummary();
            Cache::put($this->cacheManager::CACHE_PREFIX.':'.$this->term->id, $monthlyExpenses, now()->addMinutes($this->cacheExpiry));
            return $monthlyExpenses;
        }
        return $this->getMonthlyExpenseSummary();
    }


    private function getMonthlyExpenseSummary() : Collection
    {
        if($this->term){
            return $monthlyExpenseSummary = MonthlyExpenseSummary::period($this->term->id, 'term')->get()->mapWithKeys(function($item){
                return [$item['month'] => $item['amount']];
            });
        }
    }
}