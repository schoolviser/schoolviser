<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Schoolviser\Entities\Traits\HasTermlyRegistrations;
use Modules\Schoolviser\Entities\Traits\StudentHasCombination;

class SecondaryStudent extends Student
{
    use HasTermlyRegistrations, StudentHasCombination;

    protected $table = 'students';
    protected $fillable = [];


    protected static function boot()
    {
        parent::boot();
    }

}
