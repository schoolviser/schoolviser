<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\CourseGroup;

class ShowCourseGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:show-course-groups
                            {--page=1 : The page number to display}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show course groups in a table format with group name, course name, and number of students';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $page = (int) $this->option('page'); // Get the page number from the user input
        $perPage = 10; // Number of items per page

        // Fetch paginated data
        $groups = CourseGroup::with(['course', 'students'])
            ->select(['id', 'name', 'course_id']) // Select specific fields for optimization
            ->paginate($perPage, ['*'], 'page', $page);

        // Check if the page is out of range
        if ($groups->isEmpty()) {
            $this->error("No course groups found for page $page.");
            return;
        }

        // Prepare the data for the table
        $rows = $groups->map(function ($group) {
            return [
                'Group Name' => $group->name,
                'Course Name' => $group->course->name ?? 'N/A', // Course name or fallback
                'Student Count' => $group->students->count(), // Count of related students
            ];
        })->toArray();

        // Render the table
        $this->info("Showing page $page of course groups:");
        $this->table(['Group Name', 'Course Name', 'Student Count'], $rows);

        // Show pagination info
        $this->info("Page $page of {$groups->lastPage()}");
    }
}
