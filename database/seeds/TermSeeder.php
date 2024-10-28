<?php

use Illuminate\Database\Seeder;

use App\Entities\Term;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Term::create([
            'year' => 2023,
            'term' => '3',
            'start_date' => '2023-08-31',
            'end_date' => '2023-09-10'
        ]);

        Term::create([
            'year' => 2024,
            'term' => '1',
            'start_date' => '2023-09-10',
            'end_date' => '2024-12-31'
        ]);
    }
}
