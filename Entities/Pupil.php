<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Schoolviser\Entities\Traits\HasTermlyRegistrations;


class Pupil extends Student
{
    use HasTermlyRegistrations;

    protected $table = 'students';
    protected $fillable = [];


    protected static function boot()
    {
        parent::boot();
    }
}
