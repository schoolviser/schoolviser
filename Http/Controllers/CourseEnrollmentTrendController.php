<?php

namespace Modules\Schoolviser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Schoolviser\Repositories\AcademicYearRepository;
use Modules\Schoolviser\Entities\CourseEnrollmentStat;

class CourseEnrollmentTrendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function enrollmentTrend($academicYearUuid)
    {
        $company = company();
        $academicYear = app(AcademicYearRepository::class)
            ->company($company->id)
            ->getYearByUuid($academicYearUuid);

        // Fetch stats with course + term eager loaded
        $stats = CourseEnrollmentStat::where('company_id', $company->id)
            ->where('academic_year_id', $academicYear->id)
            ->with(['course', 'term'])
            ->get();

        // Transform stats into Chart.js structure
        $chartData = $this->transformStatsForChart($stats);

        return request()->expectsJson()
            ? response()->json($chartData)
            : view('schoolviser::analytics.tertiary.courses.enrollmenttrend', [
                'chartData' => $chartData
            ]);
    }

   private function transformStatsForChart($stats)
    {
        $grouped = $stats->groupBy('course_id');
        $labels = $stats->pluck('term.name')->unique()->values();
        $datasets = [];

        // Define a palette of colors (expand as needed)
        $colors = [
            'rgb(255, 99, 132)',   // red
            'rgb(54, 162, 235)',   // blue
            'rgb(255, 206, 86)',   // yellow
            'rgb(75, 192, 192)',   // teal
            'rgb(153, 102, 255)',  // purple
            'rgb(255, 159, 64)',   // orange
        ];

        $i = 0;
        foreach ($grouped as $courseId => $courseStats) {
            $courseName = optional($courseStats->first()->course)->name;

            $datasets[] = [
                'label' => $courseName,
                'data' => $labels->map(function ($label) use ($courseStats) {
                    $stat = $courseStats->firstWhere('term.name', $label);
                    return $stat ? $stat->enrolled_students_count : 0;
                }),
                'borderColor' => $colors[$i % count($colors)], // cycle through palette
                'fill' => false,
            ];

            $i++;
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

}
