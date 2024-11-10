<?php

namespace App;


class Defaults
{
    protected $defaults = [
        Defaults\ClazzDefaults::class,
        Defaults\DepartmentDefaults::class,

        \Modules\Fee\Defaults::class,
        \Modules\Accounting\Defaults::class
    ];


    public function load()
    {
        foreach ($this->defaults as $default) {
            # code...
            if(!is_null($default)){
                app($default)->load();
            }
        }
    }
    
}
