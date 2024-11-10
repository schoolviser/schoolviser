<?php

use Illuminate\Database\Seeder;

use App\Models\Academics\Subject;

use App\Models\Inventory\Store;


class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::create(['name' => 'English']);


    }
}
