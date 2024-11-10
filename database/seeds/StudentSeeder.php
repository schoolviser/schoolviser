<?php

use Illuminate\Database\Seeder;

use App\Models\Student;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

use App\Models\TermlyRegistration;


use App\Semester;
use App\Perent;

use App\Models\Fee\FeePayment;

use App\Models\Term;


class StudentSeeder extends Seeder
{

    protected $faker;
    protected $previousTerm;
    protected $currentTerm;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker::create();
        $this->previousTerm = Term::previous()->first();
        $this->currentTerm = Term::current()->first();
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->students();
        $this->newStudents();

        //$this->currentRegistrations();

        //Get Previous registrations
        $previousRegistrations = TermlyRegistration::previous()->get();

        //Populate some term one fees payments

        //foreach ($TermOneRegistrations as $registration) {
            # code...
            //FeePayment::create([
                //'amount' => 500000,
               // 'reference_id' => 'referenceid'.$registration->id,
          //     // 'termly_registration_id' => $registration->id
          //  ]);
     //   }

        //Register previous students for the current term
        if ($this->currentTerm) {
            # code...
            foreach ($previousRegistrations as $registration) {
                # code...
                TermlyRegistration::create([
                    'term_id' => $this->currentTerm->id,
                    'new_or_continuing' => 'continuing',
                    'residence' => 'boarding',
                    'hostel_id' => 1,
                    'student_id' => $registration->student_id,
                    'clazz_id' => $registration->clazz_id
                ]);
            }
        }
       

       
    }

    //Add prvious term students
    private function students()
    {
        $clazz_ids = [1,2,3,4,5,6];

        for ($x=0; $x < count($clazz_ids); $x++) { 
            # code...
            for ($i=0; $i < 5 ; $i++) { 

                $student = Student::create([
                    'photo' => config('defaults.avator'),
                    'first_name' => $this->faker->firstName,
                    'last_name'  => $this->faker->lastName,
                    'dob' => $this->faker->date,
                ]);
    
                if ($this->previousTerm) {
                    # code...
                    $registration = TermlyRegistration::create([
                        'term_id' => $this->previousTerm->id,
                        'residence' => 'boarding',
                        'new_or_continuing' => 'continuing',
                        'hostel_id' => 1,
                        'student_id' => $student->id,
                        'clazz_id' => $clazz_ids[$x]
                    ]);

                    $registration->previousBalance()->updateOrCreate([
                        'amount' => '200000',
                        'type' => 'start'
                    ]);
                }
            }
        }

    }

    private function newStudents()
    {
        $names = [
            'Justine | Omoding Angelu',
            'Stephen | Okello Omoding',
            'Sagati | Elizabeth Omoding'
        ];

        for ($i=0; $i < count($names) ; $i++) { 
            # code...
            $divideNames = explode('|', $names[$i]);

            $newStudent = Student::create([
                'photo' => config('defaults.avator'),
                'first_name' => $divideNames[0],
                'last_name'  => $divideNames[1],
                'dob' => $this->faker->date,
            ]);
            if ($this->currentTerm) {
                # code...
                $registration = TermlyRegistration::create([
                    'term_id' => $this->currentTerm->id,
                    'residence' => 'boarding',
                    'new_or_continuing' => 'new',
                    'hostel_id' => 1,
                    'student_id' => $newStudent->id,
                    'clazz_id' => 1
                ]);
            }
        }

       
    }
}
