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
            $this->syncSubjects($olevelSubjects, 'O');
        } elseif ($this->option('A')) {
            $this->syncSubjects($alevelSubjects, 'A');
        } else {
            $this->error('Please specify a level using --O or --A');
        }
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
        foreach ($subjects as $code => $name) {
            Subject::updateOrCreate(
                ['name' => $name, 'level' => $level],
                [
                    'short_code' => $code,
                    'name' => $name,
                    'level' => $level,
                    'compulsory' => '0', // Adjust as needed
                ]
            );

            $this->info("Synced: $name ($code) - Level: $level");
        }
    }
}
