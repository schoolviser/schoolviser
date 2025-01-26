<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relationships\MorphTo;

class EducationBackground extends Model
{
    //

     public function model() : MorpTo
    {
        return $this->morphTo();
    }
}
