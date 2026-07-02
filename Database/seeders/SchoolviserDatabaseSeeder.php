<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Helper\ProgressBar;

class SchoolviserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeders = [
            CompanySchoolTypeSeeder::class,
            AcademicYearSeeder::class,
            TermSeeder::class,
            ClazzSeeder::class,
            StreamSeeder::class,
            CourseSeeder::class,
            CourseGroupSeeder::class,
            SubjectSeeder::class,
            CombinationSeeder::class,
            TertiaryStudentSeeder::class,
            SecondaryStudentSeeder::class,
        ];

        $total = count($seeders);
        $this->command->info("🚀 Starting {$total} Schoolviser seeders...");

        // Initialize progress bar
        $progressBar = new ProgressBar($this->command->getOutput(), $total);
        $progressBar->setFormat(' [%bar%] %percent:3s%% | %current%/%max% seeders');
        $progressBar->start();

        foreach ($seeders as $class) {
            $this->command->line("➡️ Seeding: {$class}");

            $start = microtime(true);

            Artisan::call('db:seed', ['--class' => $class]);

            $elapsed = round(microtime(true) - $start, 2);

            $this->command->line("✅ {$class} completed in {$elapsed}s");

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->newLine(2);
        $this->command->info("🎉 All {$total} Schoolviser seeders finished successfully!");
    }
}
