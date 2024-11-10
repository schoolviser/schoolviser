<?php

namespace App\Defaults;

use App\Models\Any;
use App\Models\Department\Department;


class DepartmentDefaults
{
    public function load()
    {
        $this->get()->map(function($item, $key){
            Department::updateOrCreate([
                'name' => $item->name
            ]);
        });
    }

    public function get()
    {
        return collect([
            new Any([
                'name' => 'Accounts Department'
            ]),
            new Any([
                'name' => 'IT Department'
            ]),
            new Any([
                'name' => 'Nursing'
            ]),
            new Any([
                'name' => 'Midwifery'
            ])
        ]);
    }
}
