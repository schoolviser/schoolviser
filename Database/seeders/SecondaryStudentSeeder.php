<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Modules\Schoolviser\Entities\AcademicYear;
use Modules\Schoolviser\Entities\Term;
use Modules\Schoolviser\Entities\Clazz;

class SecondaryStudentSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local','development'])) {
            $this->command->warn('Seeder skipped: not running in development.');
            return;
        }

        $faker = Faker::create();

        $companies = DB::table('companies')
            ->whereIn('school_type', ['secondary'])
            ->get();

        foreach ($companies as $company) {
            $clazzs = Clazz::whereCompanyId($company->id)->with('streams')->get();
            if ($clazzs->isEmpty()) continue;

            $currentYear = AcademicYear::where('company_id', $company->id)->current()->first();
            $currentTerm = Term::where('academic_year_id', $currentYear->id)
                ->where('company_id', $company->id)->current()->first();

            if (! $currentYear || ! $currentTerm) continue;

            $previousTerms = Term::where('academic_year_id', $currentYear->id)
                ->where('company_id', $company->id)
                ->previous($currentTerm)
                ->get();

            foreach ($clazzs as $clazz) {
                // Create 500 students for each class
                for ($i = 1; $i <= 500; $i++) {
                    // Assign combination for S5/S6
                    $combinationId = null;
                    if (in_array($clazz->abbr, ['S5','S6'])) {
                        $combination = DB::table('combinations')
                            ->where('company_id', $company->id)
                            ->inRandomOrder()
                            ->first();
                        $combinationId = $combination?->id;
                    }

                    // Create student
                    $studentId = DB::table('students')->insertGetId([
                        'uuid'         => Str::uuid(),
                        'first_name'   => $faker->firstName,
                        'last_name'    => $faker->lastName,
                        'gender'       => $faker->randomElement(['male','female']),
                        'date_of_birth'=> $faker->dateTimeBetween('-18 years','-12 years')->format('Y-m-d'),
                        'company_id'   => $company->id,
                        'combination_id'=> $combinationId, // direct assignment
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);

                    // Assign stream (round robin)
                    $streams = $clazz->streams ?? collect();
                    $streamId = $streams->isNotEmpty() ? $streams[($i - 1) % $streams->count()]->id : null;

                    // Register in previous terms of current year
                    foreach ($previousTerms as $term) {
                        DB::table('termly_registrations')->insert([
                            'uuid'      => Str::uuid(),
                            'residence' => $faker->randomElement(['boarding','day']),
                            'new_or_continuing' => ($term->term == 1) ? 'new' : 'continuing',
                            'registered_on' => $faker->dateTimeBetween('-30 days','now')->format('Y-m-d'),
                            'meta'      => json_encode(['seeded'=>true]),
                            'locked'    => false,
                            'balance_carried_forward' => $faker->randomElement(['0',(string)rand(100,500)]),
                            'line_fees' => json_encode([
                                'tuition'    => $faker->numberBetween(500,1000),
                                'uniform'    => $faker->numberBetween(50,100),
                                'activities' => $faker->numberBetween(20,50),
                            ]),
                            'excluded_from_fees' => false,
                            'student_id' => $studentId,
                            'clazz_id'   => $clazz->id,
                            'stream_id'  => $streamId,
                            'term_id'    => $term->id,
                            'company_id' => $company->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // Record combination history for S5/S6
                        if ($combinationId) {
                            DB::table('student_combinations')->insert([
                                'uuid'            => Str::uuid(),
                                'student_id'      => $studentId,
                                'combination_id'  => $combinationId,
                                'clazz_id'        => $clazz->id,
                                'term_id'         => $term->id,
                                'academic_year_id'=> $currentYear->id,
                                'company_id'      => $company->id,
                                'created_at'      => now(),
                                'updated_at'      => now(),
                            ]);
                        }
                    }
                }
            }
        }
    }
}
