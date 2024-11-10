<?php

use Illuminate\Database\Seeder;

use App\Entities\Clazz;

class ClazzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Clazz::create([
            'name' => 'Senior One',
            'level' => 'ordinary',
            'abbr' => 'S.1',
        ]);

        Clazz::create([
            'name' => 'Senior Two',
            'level' => 'ordinary',
            'abbr' => 'S.2',
        ]);

        Clazz::create([
            'name' => 'Senior Three',
            'level' => 'ordinary',
            'abbr' => 'S.3',
        ]);

        Clazz::create([
            'name' => 'Senior Four',
            'level' => 'ordinary',
            'abbr' => 'S.4',
        ]);

        Clazz::create([
            'name' => 'Senior Five',
            'level' => 'advanced',
            'abbr' => 'S.5',
        ]);

        Clazz::create([
            'name' => 'Senior Six',
            'level' => 'advanced',
            'abbr' => 'S.6',
        ]);
        
        
    }
}
