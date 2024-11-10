<?php
namespace App\Repository;


use Illuminate\Database\Eloquent\Model;

use App\Entities\AccountingPeriod;
use App\Cache\AccountingPeriodCacheKeys as CacheKeys;

use Delgont\Core\Entities\Any;
use Illuminate\Support\Facades\Cache;

use Delgont\Core\Repository\Eloquent\BaseRepository;


class AccountingPeriodRepository extends BaseRepository
{
    protected $period;

    protected $current = false;

    public function __construct(AccountingPeriod $model){
        parent::__construct($model);
    }

    public function current()
    {
        $this->current = true;
        return $this;
    }

    //Get the current accounting period
    public function getCurrentPeriod()
    {
        return $this->cached(CacheKeys::CURRENT_PERIOD_CACHE_KEY, function(){
            return $this->model->current()->first();
        });
    }

    //Get the current accounting period
    public function getPreviousPeriod()
    {
        return $this->cached(CacheKeys::PREVIOUS_PERIOD_CACHE_KEY, function(){
            return $this->model->previous()->first();
        });
    }

    public function getNextPeriod()
    {
        return $this->cached(CacheKeys::NEXT_PERIOD_CACHE_KEY, function(){
            return $this->model->next()->first();
        });
    }


    public function getPeriods()
    {
        return $this->cached(CacheKeys::PERIODS_CACHE_KEY, function(){
            return $this->model->get();
        });
    }
    
}