<?php

namespace App\Entities;

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
}
