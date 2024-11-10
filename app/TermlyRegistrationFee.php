<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;


class TermlyRegistrationFee extends Pivot
{
    //
    public $incrementing = true;

    protected $table = 'termly_registration_fees';

}
