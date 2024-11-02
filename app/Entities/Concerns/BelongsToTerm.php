<?php

namespace App\Entities\Concerns;

use Illuminate\Database\Eloquent\Model;

use App\Models\Term;

trait BelongsToTerm
{
     
 /**
     * Get the term to which the model belongs to
     */
    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function scopeOfTerm($query, $term)
    {
        return $query->whereHas('term', function($termQuery) use ($term){
            (is_int($term)) ?  $termQuery->whereId($term) : $termQuery->whereId($term->id);
        });
    }
    
}
