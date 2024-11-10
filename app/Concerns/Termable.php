<?php

namespace App\Concerns;

use \Carbon\Carbon;
use App\Entities\Term;


trait Termable
{

    /**
     * Get model query results of specific term
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Init $term_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfTerm($query, $term)
    {
        return $query->whereHas('term', function($termQuery) use ($term){
            (is_int($term)) ? $termQuery->whereId($term) : $termQuery;
        });
    }
    /**
     * Get the query results of the current term
     */
    public function scopeCurrent($query)
    {
        return $query->whereHas('term', function($termQuery){
            $termQuery->current();
        });
    }

    /**
     * Get the model query results of the next term
     */
    public function scopeNext($query)
    {
        return $query->whereHas('term', function($termQuery){
            $termQuery->next();
        });
    }

    /**
     * Get the model query results of the next term
     */
    public function scopePrevious($query)
    {
        return $query->whereHas('term', function($termQuery){
            $termQuery->previous();
        });
    }

    /**
     * Get the term to which the model belongs
     */
    public function term()
    {
        return $this->belongsTo(Term::class, $this->getTermIdColumn());
    }

    /**
     * Get the name of the "term id" column.
     *
     * @return string
     */
    public function getTermIdColumn()
    {
        return 'term_id';
    }

}

