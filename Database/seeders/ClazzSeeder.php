<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClazzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only run in local or development environments
        if (! app()->environment(['local', 'development'])) {
            $this->command->warn('ClazzSeeder skipped: not running in development environment.');
            return;
        }

        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            if ($company->school_type === 'secondary') {
                // Seed Senior 1–6
                for ($i = 1; $i <= 6; $i++) {
                    DB::table('clazzs')->insert([
                        'uuid' => Str::uuid(),
                        'name' => "Senior {$i}",
                        'abbr' => "S{$i}",
                        'level' => $i <= 4 ? 'ordinary' : 'advanced', // S1–S4 = O-level, S5–S6 = A-level
                        'duration' => '1 year',
                        'code' => "S{$i}-{$company->id}",
                        'meta' => json_encode(['seeded' => true]),
                        'company_id' => $company->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } elseif ($company->school_type === 'primary') {
                // Optional: Seed Primary 1–7
                for ($i = 1; $i <= 7; $i++) {
                    DB::table('clazzs')->insert([
                        'uuid' => Str::uuid(),
                        'name' => "Primary {$i}",
                        'abbr' => "P{$i}",
                        'level' => 'ordinary',
                        'duration' => '1 year',
                        'code' => "P{$i}-{$company->id}",
                        'meta' => json_encode(['seeded' => true]),
                        'company_id' => $company->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                // Tertiary schools: skip or handle differently (e.g., courses instead of classes)
                $this->command->info("Skipped clazz seeding for company {$company->id} (tertiary).");
            }
        }
    }
}
