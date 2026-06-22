<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'development'])) {
            $this->command->warn('TermSeeder skipped: not running in development environment.');
            return;
        }

        $academicYears = DB::table('academic_years')->get();

        foreach ($academicYears as $year) {
            $yearStart = Carbon::parse($year->start_date);
            $yearInt   = $yearStart->year;

            // Get the company type
            $company = DB::table('companies')->where('id', $year->company_id)->first();

            if (! $company) {
                continue;
            }

            // Define terms based on school_type
            if ($company->school_type === 'tertiary') {
                // Two terms for tertiary institutions
                $terms = [
                    [
                        'term' => '1',
                        'start_date' => Carbon::create($yearInt, 1, 1),
                        'end_date'   => Carbon::create($yearInt, 6, 30),
                    ],
                    [
                        'term' => '2',
                        'start_date' => Carbon::create($yearInt, 7, 1),
                        'end_date'   => Carbon::create($yearInt, 12, 31),
                    ],
                ];
            } else {
                // Three terms for primary/secondary institutions
                $terms = [
                    [
                        'term' => '1',
                        'start_date' => Carbon::create($yearInt, 1, 1),
                        'end_date'   => Carbon::create($yearInt, 4, 30),
                    ],
                    [
                        'term' => '2',
                        'start_date' => Carbon::create($yearInt, 5, 1),
                        'end_date'   => Carbon::create($yearInt, 8, 31),
                    ],
                    [
                        'term' => '3',
                        'start_date' => Carbon::create($yearInt, 9, 1),
                        'end_date'   => Carbon::create($yearInt, 12, 31),
                    ],
                ];
            }

            // Insert terms
            foreach ($terms as $t) {
                DB::table('terms')->insert([
                    'uuid' => Str::uuid(),
                    'term' => $t['term'],
                    'start_date' => $t['start_date'],
                    'end_date' => $t['end_date'],
                    'registration_deadline' => $t['start_date']->copy()->addDays(14),
                    'exam_start_date' => $t['end_date']->copy()->subDays(14),
                    'exam_end_date' => $t['end_date'],
                    'results_release_date' => $t['end_date']->copy()->addDays(14),
                    'lock_registration' => 'open',
                    'lock_grades' => 'open',
                    'status' => 'active',
                    'next_term_start_date' => $t['term'] < count($terms) ? $t['end_date']->copy()->addDay() : null,
                    'meta' => json_encode(['seeded' => true]),
                    'academic_year_id' => $year->id,
                    'company_id' => $year->company_id,
                    'total_students' => 0,
                    'total_classes' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
