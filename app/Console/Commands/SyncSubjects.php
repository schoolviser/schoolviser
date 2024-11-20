<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\Subject;

class SyncSubjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subjects:sync {--O : Sync O Level subjects} {--A : Sync A Level subjects}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync subjects into the database based on level (O Level or A Level)';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $olevelSubjects = config('schoolviser.olevel_subjects', []);
        $alevelSubjects = config('schoolviser.alevel_subjects', []);

        

        if ($this->option('O')) {
            // Prompt the user for confirmation
            if (!$this->confirm('Do you wish to sync O level subjects into the database?', true)) {
                $this->info('Subjects synchronization canceled.');
                return Command::SUCCESS;
            }
            $this->info('Starting sync for O Level subjects...');
            $this->syncSubjects($olevelSubjects, 'O');
        } elseif ($this->option('A')) {
            if (!$this->confirm('Do you wish to sync A level subjects into the database?', true)) {
                $this->info('Subjects synchronization canceled.');
                return Command::SUCCESS;
            }
            $this->info('Starting sync for A Level subjects...');
            $this->syncSubjects($alevelSubjects, 'A');
        } else {
            $this->error('Please specify a level using --O or --A');
            return;
        }

        $this->info("\n🎉 DONE: Subjects have been successfully synced!");
    }

    /**
     * Sync subjects based on the provided subjects list and level.
     *
     * @param array $subjects
     * @param string $level
     * @return void
     */
    protected function syncSubjects(array $subjects, string $level): void
    {
        if (empty($subjects)) {
            $this->warn("No subjects found to sync for Level: $level.");
            return;
        }

        

        $this->info("Syncing " . count($subjects) . " subjects for Level: $level...");
        
        // Initialize counters for added/updated subjects
        $addedCount = 0;
        $updatedCount = 0;

        // Create a progress bar
        $this->output->progressStart(count($subjects));

        foreach ($subjects as $code => $name) {
            $subject = Subject::updateOrCreate(
                ['name' => $name, 'level' => $level],
                [
                    'short_code' => $code,
                    'name' => $name,
                    'level' => $level,
                    'compulsory' => '0', // Adjust as needed
                ]
            );

            // Count additions and updates
            if ($subject->wasRecentlyCreated) {
                $addedCount++;
            } else {
                $updatedCount++;
            }

            // Advance the progress bar
            $this->output->progressAdvance();
        }

        // Finish the progress bar
        $this->output->progressFinish();

        // Show summary
        $this->info("\nSummary for Level: $level");
        $this->info("Subjects Added: $addedCount");
        $this->info("Subjects Updated: $updatedCount");
    }
}
