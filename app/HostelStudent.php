<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\HosyelRoom;

class HostelStudent extends Pivot
{
    //

    public $incrementing = true;

    protected $with = ['room'];

    public function scopeCurrent($query)
    {
    }


    public function room()
    {
        return $this->hasOne(HostelRoom::class);
    }
}
