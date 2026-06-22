<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySchoolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only run in local or development environments
        if (! app()->environment(['local', 'development'])) {
            $this->command->warn('CompanySchoolTypeSeeder skipped: not running in development environment.');
            return;
        }

        $companies = DB::table('companies')->get();

        // Rotation pattern
        $types = ['secondary', 'tertiary', 'primary'];

        foreach ($companies as $index => $company) {
            $schoolType = $types[$index % count($types)];

            DB::table('companies')
                ->where('id', $company->id)
                ->update(['school_type' => $schoolType]);
        }

        $this->command->info('School types assigned to companies in rotating order.');
    }
}
