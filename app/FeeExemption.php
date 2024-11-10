<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models\TermlyRegistration;

class FeeExemption extends Model
{
    //Get current fee exemptions
    public function scopeCurrent($query)
    {
        return $query->where('year', option('current_year'))->whereTerm(option('current_term'));
    }

    //Get fee exemptions of specific term
    public function scopeOfTerm($query, $term)
    {
        return $query->whereTerm($term);
    }

    //Get fee exemptions of specific year
    public function scopeOfYear($query, $year)
    {
        return $query->where('year', $year);
    }

    //get fee exemptions of specific class
    public function scopeOfClass($query, $class_id = null, $year = null, $term = null)
    {
        if($class_id){
            return $query->whereHas('termlyRegistration', function($termlyRegistrationQuery) use ($class_id){
                $termlyRegistrationQuery->whereClazzId($class_id);
            });
        }
        return $query;
    }

    //Get termly registrations linked to the exemption
    public function termlyRegistration()
    {
        return $this->belongsTo(TermlyRegistration::class, 'termly_registration_id');
    }

}
