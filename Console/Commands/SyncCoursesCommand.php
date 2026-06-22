<?php

namespace Modules\Schoolviser\Console\Commands;

use Illuminate\Console\Command;
use Modules\Schoolviser\Entities\Course;
use App\Models\Company;
use Illuminate\Support\Str;

class SyncCoursesCommand extends Command
{
    protected $signature = 'schoolviser:sync-courses {company? : Company ID, UUID, or "all"}';
    protected $description = 'Sync predefined courses into the database for a specific company or all companies';

    public function handle()
    {
        $companyArg = $this->argument('company');

        // Determine target companies
        if ($companyArg === 'all') {
            $companies = Company::all();
        } elseif ($companyArg) {
            $companies = Company::where('id', $companyArg)
                ->orWhere('uuid', $companyArg)
                ->get();
        } else {
            $this->error('You must specify a company ID/UUID or "all".');
            return Command::FAILURE;
        }

        if ($companies->isEmpty()) {
            $this->error("No matching companies found.");
            return Command::FAILURE;
        }

        $courses = config('schoolviser.courses', []);
        if (empty($courses)) {
            $this->error('No courses found in the configuration file.');
            return Command::FAILURE;
        }

        foreach ($companies as $company) {
            $this->info("Syncing courses for company: {$company->id} ({$company->name})");
            $this->output->progressStart(count($courses));

            foreach ($courses as $abbr => $name) {
                Course::updateOrCreate(
                    // Match clause
                    [
                        'company_id' => $company->id,
                        'abbr'       => $abbr,
                    ],
                    // Values for insert/update
                    [
                        'company_id' => $company->id,
                        'abbr'       => $abbr,
                        'name'       => $name,
                        'award'      => $name,
                        'uuid'       => Str::uuid(),
                    ]
                );

                $this->output->progressAdvance();
            }

            $this->output->progressFinish();
            $this->info("Courses synced successfully for company {$company->id}.");
        }

        return Command::SUCCESS;
    }
}