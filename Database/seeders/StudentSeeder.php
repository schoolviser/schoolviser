<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local','development'])) {
            $this->command->warn('PrimarySecondaryStudentSeeder skipped: not running in development environment.');
            return;
        }

        $faker = Faker::create();

        // Fetch companies that are primary or secondary
        $companies = DB::table('companies')
            ->whereIn('school_type', ['primary','secondary'])
            ->get();

        foreach ($companies as $company) {
            // Fetch classes for this company
            $clazzs = DB::table('clazzs')
                ->where('company_id', $company->id)
                ->orderBy('abbr','asc') // ensure S1..S6 or P1..P7 in order
                ->get();

            if ($clazzs->isEmpty()) {
                $this->command->warn("No classes found for company {$company->id}, skipping.");
                continue;
            }

            // Create ~50 students
            for ($i = 1; $i <= 50; $i++) {
                $studentId = DB::table('students')->insertGetId([
                    'uuid'         => Str::uuid(),
                    'first_name'   => $faker->firstName,
                    'last_name'    => $faker->lastName,
                    'gender'       => $faker->randomElement(['male','female']),
                    'date_of_birth'=> $faker->dateTimeBetween('-18 years','-12 years')->format('Y-m-d'),
                    'company_id'   => $company->id,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);

                // Get academic years ordered
                $academicYears = DB::table('academic_years')
                    ->where('company_id',$company->id)
                    ->orderBy('start_date','asc')
                    ->get();

                $classIndex = 0; // start at first class (S1 or P1)

                foreach ($academicYears as $yearIndex => $year) {
                    // Get terms for this academic year
                    $terms = DB::table('terms')
                        ->where('academic_year_id',$year->id)
                        ->where('company_id',$company->id)
                        ->orderBy('term','asc')
                        ->get();

                    // Assign current class
                    if ($classIndex < count($clazzs)) {
                        $clazz = $clazzs[$classIndex];
                    } else {
                        // Student has finished all classes
                        break;
                    }

                    foreach ($terms as $term) {
                        DB::table('termly_registrations')->insert([
                            'uuid'                  => Str::uuid(),
                            'residence'             => $faker->randomElement(['boarding','day']),
                            'new_or_continuing'     => ($yearIndex === 0 && $term->term == 1) ? 'new' : 'continuing',
                            'registered_on'         => $faker->dateTimeBetween('-30 days','now')->format('Y-m-d'),
                            'meta'                  => json_encode(['seeded'=>true]),
                            'locked'                => false,
                            'balance_carried_forward'=> $faker->randomElement(['0',(string)rand(100,500)]),
                            'line_fees'             => json_encode([
                                'tuition'=>$faker->numberBetween(500,1000),
                                'uniform'=>$faker->numberBetween(50,100),
                                'activities'=>$faker->numberBetween(20,50),
                            ]),
                            'excluded_from_fees'    => false,
                            'student_id'            => $studentId,
                            'clazz_id'              => $clazz->id,
                            'term_id'               => $term->id,
                            'company_id'            => $company->id,
                            'created_at'            => now(),
                            'updated_at'            => now(),
                        ]);
                    }

                    // Move student to next class for next academic year
                    $classIndex++;
                }
            }
        }
    }
}
