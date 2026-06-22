<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\Course;

class ShowCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:show-courses {--page=1 : The page number for paginated results}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display paginated results of courses in a table format';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $page = (int) $this->option('page'); // Get the page option
        $perPage = 10; // Number of results per page

        // Fetch paginated results of courses
        $courses = Course::query()->paginate($perPage, ['*'], 'page', $page);

        if ($courses->isEmpty()) {
            $this->warn("No courses found for page $page.");
            return Command::SUCCESS;
        }

        // Prepare data for the table
        $data = $courses->map(function ($course) {
            return [
                'ID' => $course->id,
                'UUID' => $course->uuid,
                'Name' => $course->name,
                'Abbr' => $course->abbr,
            ];
        })->toArray();

        // Render the table
        $this->table(['ID', 'UUID', 'Name', 'Abbr'], $data);

        // Display navigation info
        $this->info("Showing page $page of {$courses->lastPage()}. Total courses: {$courses->total()}.");

        return Command::SUCCESS;
    }
}
