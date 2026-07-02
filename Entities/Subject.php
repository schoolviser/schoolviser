<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $guarded = [];


    public function scopeOlevel($query)
    {
        return $query->whereLevel('o');
    }

    public function scopeAlevel($query)
    {
        return $query->whereLevel('a');
    }

    public function papers()
    {
        return $this->hasMany(SubjectPaper::class);
    }

    /**
     * Get compulsory papers for this subject.
     */
    public function compulsoryPapers()
    {
        return $this->papers()->compulsory();
    }

    /**
     * Get optional papers for this subject.
     */
    public function optionalPapers()
    {
        return $this->papers()->optional();
    }

}
