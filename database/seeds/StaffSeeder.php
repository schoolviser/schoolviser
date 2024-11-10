<?php

use Illuminate\Database\Seeder;

use App\MOdels\Employee\Employee;
use App\Models\Employee\EmployeePosition;
use App\Models\Department\Department;

use Faker\Factory as Faker;


class StaffSeeder extends Seeder
{
    protected $faker;

    protected $staff_positions = [
        'Head Teacher', 'Auditor', 'IT Manager', 'Teacher'
    ];

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
        foreach ($this->staff_positions as $item) {
            EmployeePosition::updateOrCreate(['name' => $item], [
                'name' => $item
            ]);
        }

        for ($i=0; $i < 5; $i++) { 
            $staff = Employee::create([
                'first_name'  => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'date_of_birth' => $this->faker->date,
                'email' => $this->faker->email,
                'primary_phone' => $this->faker->phoneNumber,
                'employee_position_id' => 1,
            ]);

            $departmenets = Department::all();
            foreach ($departmenets as $department) {
                # code...
                $staff->departments()->attach($department->id);
            }
        }
    }
}
