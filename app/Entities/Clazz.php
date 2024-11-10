<?php

namespace App\Entities;

use Modules\Student\Entities\TermlyRegistration;


use Illuminate\Database\Eloquent\Model;

use Modules\Fee\Entities\Fee;
use App\Models\Requirement\Requirement;
use App\Models\Academics\Routine;

use Delgont\Core\Concerns\ModelHasMeta;

class Clazz extends Model
{
    use ModelHasMeta;

    protected $fillable = ['name', 'level', 'abbr'];

    /**
     * Get level attribute
     */
    public function getLevelAttribute($value)
    {
        return $value;
    }
    
    public function termlyRegistrations()
    {
        return $this->hasMany(TermlyRegistration::class, 'clazz_id');
    }


    public function currentTermlyRegistrations()
    {
        return $this->hasMany(TermlyRegistration::class)->whereHas('term', function($termQuery){
            $termQuery->current();
        });
    }
    

    public function currentFees()
    {
        return $this->hasMany(Fee::class, 'clazz_id')->whereTerm(option('current_term'))->where('year', option('current_year'));
    }

    public function fees()
    {
        return $this->hasMany(Fee::class, 'clazz_id');
    }

    /**
     * Fee discounts that apply to this class
     */
    public function feeDiscounts()
    {
        return $this->morphMany('App\Models\Fee\FeeDiscount', 'discountable');
    }


    //Get the requiremnets for a specific class
    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'clazz_id');
    }

    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

}
