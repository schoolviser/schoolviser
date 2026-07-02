<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only run in local or development environments
        if (! app()->environment(['local', 'development'])) {
            $this->command->warn('StreamSeeder skipped: not running in development environment.');
            return;
        }

        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            if (in_array($company->school_type, ['primary', 'secondary'])) {
                // Get all classes for this company
                $clazzs = DB::table('clazzs')->where('company_id', $company->id)->get();

                foreach ($clazzs as $clazz) {
                    // Seed default streams (A, B)
                    foreach (['A', 'B'] as $suffix) {
                        DB::table('streams')->insert([
                            'uuid' => Str::uuid(),
                            'name' => "{$clazz->abbr}{$suffix}", // e.g., S1A, P5B
                            'abbr' => $suffix,
                            'active' => true,
                            'clazz_id' => $clazz->id,
                            'company_id' => $company->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            } else {
                // Skip tertiary companies
                $this->command->info("Skipped stream seeding for company {$company->id} (tertiary).");
            }
        }
    }
}
