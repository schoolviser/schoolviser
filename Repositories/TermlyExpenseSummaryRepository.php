<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\TermlyExpenseSummary;
use Modules\Schoolviser\Cache\CacheKeys\TermlyExpenseSummaryCacheKeys as CacheKeys;

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
