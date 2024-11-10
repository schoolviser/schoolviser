<?php

namespace App\Concerns;

use \Carbon\Carbon;
use App\Group;

trait Groupable {

    public static function bootArchivable()
	{
        static::addGlobalScope(new ArchivableScope);
	}

    public function groups()
    {
        return $this->morphMany(Group::class, 'groupable');
    }

}
