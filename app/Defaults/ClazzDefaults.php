<?php

namespace App\Defaults;

use Delgont\Core\Entities\Any;
use App\Entities\Clazz;

use App\Models\Department\Department;



class ClazzDefaults
{
    public function load()
    {
        $this->get()->map(function($item, $key){
            Clazz::updateOrCreate([
                'name' => $item->name,
                'level' => $item->level,
                'abbr' => $item->abbr
            ]);
        });
    }

    public function get()
    {
        return collect([
            new Any([
                'name' => 'Senior One',
                'level' => 'ordinary',
                'abbr' => 'S.1',
            ]),
            new Any([
                'name' => 'Senior Two',
                'level' => 'ordinary',
                'abbr' => 'S.2',
            ]),
            new Any([
                'name' => 'Senior Three',
                'level' => 'ordinary',
                'abbr' => 'S.3',
            ]),
            new Any([
                'name' => 'Senior Four',
                'level' => 'ordinary',
                'abbr' => 'S.4',
            ]),
            new Any([
                'name' => 'Senior Five',
                'level' => 'advanced',
                'abbr' => 'S.5',
            ]),
            new Any([
                'name' => 'Senior Six',
                'level' => 'advanced',
                'abbr' => 'S.6',
            ])
        ]);
    }
}
