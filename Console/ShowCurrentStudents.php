<?php

namespace Modules\Student\Console;

use Illuminate\Console\Command;

use Modules\Student\Entities\IntakeRegistration;

class ShowCurrentStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:show-current-students {--page=1 : The page number for pagination}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display current students of the current intake in a paginated table format';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the current students using the current() scope
        $studentsQuery = IntakeRegistration::current()->with(['student.course', 'student.currentIntakeRegistration.term']);

        // Paginate results
        $page = $this->option('page');
        $perPage = 10;
        $students = $studentsQuery->paginate($perPage, ['*'], 'page', $page);

        if ($students->isEmpty()) {
            $this->info('No current students found.');
            return 0;
        }

        // Prepare data for the table
        $data = $students->map(function ($registration) {
            return [
                'Access Number' => $registration->student->access_number ?? 'N/A',
                'First Name'    => $registration->student->first_name ?? 'N/A',
                'Last Name'     => $registration->student->last_name ?? 'N/A',
                'Gender'        => ucfirst($registration->student->gender ?? 'N/A'),
                'Course'        => $registration->student->course->name ?? 'N/A',
                'Semester'      => $registration->semester ?? 'N/A',
                'Entry Date'    => $registration->student->entry_date ?? 'N/A',
            ];
        })->toArray();

        // Display table
        $this->table(['Access Number', 'First Name', 'Last Name', 'Gender', 'Course', 'Semester',  'Entry Date'], $data);

        // Output pagination info
        $this->info("Page {$students->currentPage()} of {$students->lastPage()}");

        return 0;
    }
}
