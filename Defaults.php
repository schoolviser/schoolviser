<?php

namespace App;


class Defaults
{
    protected $defaults = [
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
