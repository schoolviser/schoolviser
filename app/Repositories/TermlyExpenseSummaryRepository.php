<?php

namespace App\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use App\Entities\TermlyExpenseSummary;
use App\Cache\CacheKeys\TermlyExpenseSummaryCacheKeys as CacheKeys;

class TermlyExpenseSummaryRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(TermlyExpenseSummary $model)
    {
        parent::__construct($model);
    }

    public function getCurrentSummary()
    {
        return $this->cached(CacheKeys::CURRENT_SUMMARY, function(){
            return $this->model->current()->get();
        });
    }
   
}
