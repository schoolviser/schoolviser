<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only run in local or development environments
        if (! app()->environment(['local', 'development'])) {
            $this->command->warn('AcademicYearSeeder skipped: not running in development environment.');
            return;
        }

        $companies = DB::table('companies')->pluck('id');
        $currentYear = Carbon::now()->year;

        foreach ($companies as $companyId) {
            // Randomly decide how many academic years to create (between 2 and 5)
            $count = 1;

            for ($i = 0; $i < $count; $i++) {
                $year = $currentYear - $i;

                DB::table('academic_years')->insert([
                    'uuid' => Str::uuid(),
                    'name' => (string) $year,
                    'start_date' => Carbon::create($year, 1, 1),
                    'end_date' => Carbon::create($year, 12, 31),
                    'meta' => json_encode(['seeded' => true]),
                    'total_students' => 0,
                    'total_staff' => 0,
                    'total_classes' => 0,
                    'is_active' => $i === 0,
                    'is_locked' => false,
                    'company_id' => $companyId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
