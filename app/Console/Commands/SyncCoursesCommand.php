<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\Course;

class SyncCoursesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:sync-courses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync predefined courses into the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting the course synchronization process...');

        // Prompt the user for confirmation
        if (!$this->confirm('Do you wish to sync courses into the database?', true)) {
            $this->info('Course synchronization canceled.');
            return Command::SUCCESS;
        }

        // Get courses from the configuration file
        $courses = config('schoolviser.courses', []);

        if (empty($courses)) {
            $this->error('No courses found in the configuration file.');
            return Command::FAILURE;
        }

        $this->output->progressStart(count($courses));

        // Sync courses into the database
        foreach ($courses as $abbr => $name) {
            Course::updateOrCreate(
                ['abbr' => $abbr],
                ['name' => $name]
            );

            $this->output->progressAdvance();
        }
        $this->output->progressFinish();

        $this->info('All courses have been synced successfully!');
        return Command::SUCCESS;
    }
}
