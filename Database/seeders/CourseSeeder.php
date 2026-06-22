<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only run in local or development environments
        if (! app()->environment(['local', 'development'])) {
            $this->command->warn('CourseSeeder skipped: not running in development environment.');
            return;
        }

        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            if ($company->school_type !== 'tertiary') {
                $this->command->info("Skipped courses for company {$company->id} ({$company->school_type}).");
                continue;
            }

            // Example courses for tertiary institutions
            $courses = [
                [
                    'name' => 'Bachelor of Science in Computer Science',
                    'abbr' => 'BSc CS',
                    'award' => 'Bachelor of Science',
                    'duration' => 3,
                ],
                [
                    'name' => 'Diploma in Business Administration',
                    'abbr' => 'DBA',
                    'award' => 'Diploma',
                    'duration' => 2,
                ],
                [
                    'name' => 'Bachelor of Nursing',
                    'abbr' => 'BN',
                    'award' => 'Bachelor of Nursing',
                    'duration' => 4,
                ],
            ];

            foreach ($courses as $course) {
                $courseId = DB::table('courses')->insertGetId([
                    'uuid' => Str::uuid(),
                    'name' => $course['name'],
                    'decription' => null,
                    'abbr' => $course['abbr'],
                    'award' => $course['award'],
                    'duration' => $course['duration'],
                    'meta' => json_encode(['seeded' => true]),
                    'department_id' => null,
                    'company_id' => $company->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Seed a few course units per course
                for ($year = 1; $year <= $course['duration']; $year++) {
                    for ($semester = 1; $semester <= 2; $semester++) {
                        DB::table('course_units')->insert([
                            'uuid' => Str::uuid(),
                            'name' => "Course Unit Y{$year}S{$semester}",
                            'code' => strtoupper(Str::random(6)),
                            'year' => (string) $year,
                            'semester' => (string) $semester,
                            'description' => "Sample unit for {$course['abbr']} Year {$year} Semester {$semester}",
                            'meta' => json_encode(['seeded' => true]),
                            'course_id' => $courseId,
                            'company_id' => $company->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
