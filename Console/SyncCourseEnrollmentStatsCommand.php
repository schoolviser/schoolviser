<?php

namespace Modules\Schoolviser\Console;

use Illuminate\Console\Command;
use Modules\Schoolviser\Jobs\SyncCourseEnrollmentStatsJob;

class SyncCourseEnrollmentStatsCommand extends Command
{
    protected $signature = 'schoolviser:sync-course-enrollment {academicYearId} {companyId}';
    protected $description = 'Sync course enrollment statistics for a given academic year and company';

    public function handle()
    {
        $academicYearId = $this->argument('academicYearId');
        $companyId = $this->argument('companyId');

        SyncCourseEnrollmentStatsJob::dispatch($academicYearId, $companyId);

        $this->info("Enrollment stats sync dispatched for Academic Year {$academicYearId}, Company {$companyId}");
    }
}
