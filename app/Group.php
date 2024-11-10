<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Student;

class Group extends Model
{
    /**
     * Get groups for specific model type
     */
    public function scopeGroups($query, $model = null)
    {
        return ($model) ? $query->whereType(($model instanceof Model) ? get_class($model) : $model)->orWhere('type', null) : $query;
    }

    
    /**
     * Get groups for specific model type
     */
    public function scopeOf($query, $model = null)
    {
        return ($model) ? $query->whereType(($model instanceof Model) ? get_class($model) : $model)->orWhere('type', null) : $query;
    }


    /**
     * Get all of the students that belong to this group
     */
    public function students()
    {
        $year = option('current_year');
        $term = option('current_term');

        return $this->morphedByMany(Student::class, 'groupable')->with(['registrations' => function($query) use ($term, $year){
            return $query->whereTerm($term)->where('year', $year);
        }]);
    }




}
