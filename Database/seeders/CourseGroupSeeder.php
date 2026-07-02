<?php
namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Schoolviser\Entities\CourseGroup;
use Modules\Schoolviser\Entities\Course;
use Modules\Schoolviser\Entities\Term;
use App\Models\Company;

class CourseGroupSeeder extends Seeder
{
    public function run()
    {
        // Loop through each company
        $companies = Company::whereSchoolType('tertiary')->get();

        foreach ($companies as $company) {
            // Get courses for this company
            $courses = Course::where('company_id', $company->id)->get();

            // You can decide which term(s) to use — here we take the first term per company
            $term = Term::where('company_id', $company->id)->first();

            foreach ($courses as $course) {
                CourseGroup::create([
                    'uuid'        => Str::uuid(),
                    'short_code'  => strtoupper(substr($course->abbr ?? $course->name, 0, 5)) . date('Y'),
                    'name'        => ($course->abbr ?? $course->name) . ' Class of ' . date('Y'),
                    'description' => 'Auto-generated course group for ' . $course->name,
                    'graduated'   => '0',
                    'active'      => '1',
                    'company_id'  => $company->id,
                    'course_id'   => $course->id,
                    'term_id'     => $term?->id,
                ]);
            }
        }
    }
}
