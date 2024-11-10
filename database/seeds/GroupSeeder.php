<?php

use Illuminate\Database\Seeder;

use App\Group;
use App\Student;

use Faker\Factory as Faker;


class GroupSeeder extends Seeder
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
       for ($i=0; $i < 10; $i++) { 
        # code...
        Group::updateOrCreate(['name' => $this->faker->firstName], [
            'name' => $this->faker->firstName,
            'type' => Student::class
        ]);
       }
    }
}
