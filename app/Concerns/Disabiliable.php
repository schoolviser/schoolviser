<?php

namespace App\Concerns;

use App\Disability;


trait Disabiliable {

    public function disabilities()
    {
        return $this->morphToMany(Disability::class, 'disabiliable');
    }

}
