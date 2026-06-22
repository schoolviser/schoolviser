<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class TertiaryStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'development'])) {
            $this->command->warn('TertiaryStudentSeeder skipped: not running in development environment.');
            return;
        }

        $faker = Faker::create();

        // Fetch all companies that are tertiary institutions
        $companies = DB::table('companies')->where('school_type', 'tertiary')->get();

        foreach ($companies as $company) {
            // Fetch courses for this company
            $courses = DB::table('courses')
                ->where('company_id', $company->id)
                ->pluck('id');

            if ($courses->isEmpty()) {
                $this->command->warn("No courses found for company {$company->id}, skipping student seeding.");
                continue;
            }

            // Create ~50 students per tertiary company
            for ($i = 1; $i <= 50; $i++) {
                // Randomly assign a course to the student
                $courseId = $faker->randomElement($courses->toArray());

                $studentId = DB::table('students')->insertGetId([
                    'uuid'         => Str::uuid(),
                    'first_name'   => $faker->firstName,
                    'last_name'    => $faker->lastName,
                    'gender'       => $faker->randomElement(['male', 'female']),
                    'date_of_birth'=> $faker->dateTimeBetween('-25 years', '-18 years')->format('Y-m-d'),
                    'company_id'   => $company->id,
                    'course_id'    => $courseId, // <-- assign course
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);

                // Get the earliest academic year for this company
                $academicYear = DB::table('academic_years')
                    ->where('company_id', $company->id)
                    ->orderBy('start_date', 'asc')
                    ->first();

                if (! $academicYear) {
                    continue;
                }

                // Get terms (intakes) for that academic year
                $terms = DB::table('terms')
                    ->where('academic_year_id', $academicYear->id)
                    ->where('company_id', $company->id)
                    ->orderBy('term', 'asc')
                    ->get();

                foreach ($terms as $term) {
                    DB::table('intake_registrations')->insert([
                        'uuid'                  => Str::uuid(),
                        'residence'             => $faker->randomElement(['boarding', 'day']),
                        'new_or_continuing'     => $i <= 10 ? 'new' : 'continuing',
                        'semester'              => (string) $term->term, // FIXED: use property
                        'year'                  => '1',
                        'locked'                => false,
                        'retake'                => false,
                        'registered_on'         => $faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
                        'balance_carried_forward' => $faker->randomElement(['0', (string) rand(100, 500)]),
                        'line_fees'             => json_encode([
                            'tuition' => $faker->numberBetween(1000, 2000),
                            'library' => $faker->numberBetween(50, 100),
                            'lab'     => $faker->numberBetween(100, 300),
                        ]),
                        'meta'                  => json_encode(['seeded' => true]),
                        'student_id'            => $studentId,
                        'term_id'               => $term->id,
                        'academic_year_id'      => $academicYear->id,
                        'company_id'            => $company->id,
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);
                }
            }
        }
    }
}
