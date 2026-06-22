<?php

namespace Modules\Schoolviser\Console;

use Illuminate\Console\Command;
use Modules\Schoolviser\Entities\Student;
use App\Models\Company;

class GenerateStudentAccessNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:gsan 
    {company : The company ID or UUID or delxero_account_number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate unique access numbers for students based on their ID.';

    /**
     * Execute the console command.
     *
     * @return int
     */
   public function handle()
{
    $companyIdentifier = $this->argument('company');

    // Resolve company by id, uuid, or delxero_account_number
    $company = Company::query()
        ->where('id', $companyIdentifier)
        ->orWhere('uuid', $companyIdentifier)
        ->orWhere('delxero_account_number', $companyIdentifier)
        ->first();

    if (!$company) {
        $this->error("Company not found for identifier: {$companyIdentifier}");
        return 1;
    }

    // Query students for this company only
    $students = Student::where('company_id', $company->id)->get();

    if ($students->isEmpty()) {
        $this->info("No students found for company {$company->id}.");
        return 0;
    }

    // Determine the next sequence number for this company
    $lastAccessNumber = Student::where('company_id', $company->id)
        ->whereNotNull('access_number')
        ->orderBy('access_number', 'desc')
        ->value('access_number');

    $counter = $lastAccessNumber
        ? (int)substr($lastAccessNumber, 1) // strip leading "A"
        : 0;

    foreach ($students as $student) {
        if ($student->access_number) {
            $this->line("Skipping student ID {$student->id}, already has {$student->access_number}.");
            continue;
        }

        $counter++;
        $accessNumber = sprintf('A%05d', $counter);

        // Ensure uniqueness scoped to company
        if (Student::where('company_id', $company->id)
                   ->where('access_number', $accessNumber)
                   ->exists()) {
            $this->error("Duplicate access number {$accessNumber} in company {$company->id}.");
            continue;
        }

        $student->update(['access_number' => $accessNumber]);
        $this->info("Generated {$accessNumber} for student ID {$student->id}.");
    }

    $this->info("Access number generation completed for company {$company->id}.");
    return 0;
}
}
