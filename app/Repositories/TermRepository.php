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

    public function getActiveTerms()
    {
        return $this->cached(CacheKeys::ACTIVE_TERMS, function(){
            return $this->model::active()->get();
        });
    }

    public function getAll()
    {
        return $this->cached(CacheKeys::TERMS, function(){
            return $this->model->get();
        });
    }

    public function getTerm($id)
    {
        return $this->cached(CacheKeys::TERM.$id, function () use ($id) {
            return $this->model
                ->where('id', $id)
                ->orWhere('uuid', $id)
                ->firstOrFail();
        });
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
