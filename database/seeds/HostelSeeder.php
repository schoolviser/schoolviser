<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Models\Hostel;
use App\Student;

class HostelSeeder extends Seeder
{
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker::create();
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hostel = Hostel::create([
            'name' => 'Boys Hostel',
            'gender' => 'male',
        ]);

    }
}
