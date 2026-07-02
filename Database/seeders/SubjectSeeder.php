<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local','development'])) {
            $this->command->warn('SubjectSeeder skipped: not running in production.');
            return;
        }

        $olevelSubjects = config('schoolviser.olevel_subjects');
        $alevelSubjects = config('schoolviser.alevel_subjects');

        // Fetch only secondary companies
        $companies = DB::table('companies')
            ->where('school_type', 'secondary')
            ->get();

        foreach ($companies as $company) {
            $this->command->info("➡️ Seeding subjects for company {$company->id}");

            // Seed O-Level subjects
            foreach ($olevelSubjects as $code => $name) {
                DB::table('subjects')->updateOrInsert(
                    [
                        'company_id' => $company->id,
                        'short_code' => $code,
                        'level'      => 'o',
                    ],
                    [
                        'uuid'        => Str::uuid(),
                        'name'        => $name,
                        'short_name'  => substr($name, 0, 15), // optional short name
                        'compulsory'  => in_array($code, ['112','456','553']) ? true : false, // example compulsory subjects
                        'meta'        => json_encode(['seeded' => true]),
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]
                );
            }

            // Seed A-Level subjects
            foreach ($alevelSubjects as $code => $name) {
                DB::table('subjects')->updateOrInsert(
                    [
                        'company_id' => $company->id,
                        'short_code' => $code,
                        'level'      => 'a',
                    ],
                    [
                        'uuid'        => Str::uuid(),
                        'name'        => $name,
                        'short_name'  => substr($name, 0, 15),
                        'compulsory'  => ($code === '000'), // General Paper is compulsory
                        'meta'        => json_encode(['seeded' => true]),
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]
                );
            }
        }

        $this->command->info("✅ SubjectSeeder completed.");
    }
}
