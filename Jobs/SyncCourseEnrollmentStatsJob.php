<?php

namespace Modules\Schoolviser\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Modules\Schoolviser\Entities\CourseEnrollmentStat;
use Modules\Schoolviser\Entities\Course;
use Modules\Schoolviser\Entities\Term;

class SyncCourseEnrollmentStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $academicYearId;
    protected $companyId;

    public function __construct($academicYearId, $companyId)
    {
        $this->academicYearId = $academicYearId;
        $this->companyId = $companyId;
    }

    public function handle()
    {
        $terms = Term::where('company_id', $this->companyId)
            ->where('academic_year_id', $this->academicYearId)
            ->get();

        foreach ($terms as $term) {
            $courses = Course::where('company_id', $this->companyId)->get();

            foreach ($courses as $course) {
                $count = $term->intakeRegistrations()
                    ->whereHas('student', function ($q) use ($course) {
                        $q->where('course_id', $course->id);
                    })
                    ->count();

                CourseEnrollmentStat::updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'term_id' => $term->id,
                        'academic_year_id' => $this->academicYearId,
                        'company_id' => $this->companyId,
                    ],
                    ['enrolled_students_count' => $count]
                );
            }
        }
    }
}
