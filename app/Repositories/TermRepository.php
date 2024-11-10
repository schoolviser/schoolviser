<?php

namespace App\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use App\Entities\Term;
use App\Cache\CacheKeys\TermCacheKeys as CacheKeys;

class TermRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Term $model)
    {
        parent::__construct($model);
    }


    public function getCurrentTerm()
    {
        return $this->cached(CacheKeys::CURRENT_TERM, function(){
            return $this->model->current()->first();
        });
    }

    //Get the previous term
    public function getPreviousTerm()
    {
        return $this->cached(CacheKeys::PREVIOUS_TERM, function(){
            return $this->model->previous()->first();
        });
    }

   
}
