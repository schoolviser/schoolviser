<?php

namespace Modules\Student\Console;

use Illuminate\Console\Command;
use Modules\Student\Entities\Student;

class FindStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:find-student
                            {query : The search query (access_number, regno, first_name, or course)}
                            {--page=1 : The page number for paginated results}
                            {--per-page=10 : The number of results per page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find a student by access_number, regno, first_name, or course, with pagination support';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = $this->argument('query');
        $page = (int) $this->option('page');
        $perPage = (int) $this->option('per-page');

        // Search for students by access_number, regno, first_name, or course
        $students = Student::query()
            ->where('access_number', 'LIKE', "%$query%")
            ->orWhere('regno', 'LIKE', "%$query%")
            ->orWhere('first_name', 'LIKE', "%$query%")
            ->paginate($perPage, ['*'], 'page', $page);

        if ($students->isEmpty()) {
            $this->warn("No students found matching the query: '$query' on page $page.");
            return Command::SUCCESS;
        }

        // Prepare data for the table
        $data = $students->map(function ($student) {
            return [
                'ID' => $student->id,
                'Access Number' => $student->access_number,
                'Reg No' => $student->regno,
                'First Name' => $student->first_name,
                'Course' => $student->course->name ?? 'N/A',
            ];
        })->toArray();

        // Display the table
        $this->table(['ID', 'Access Number', 'Reg No', 'First Name', 'Course'], $data);

        // Show pagination info
        $this->info("Page $page of {$students->lastPage()} | Showing {$students->count()} of {$students->total()} students.");

        return Command::SUCCESS;
    }
}
