<?php

namespace Modules\Schoolviser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Schoolviser\Entities\IntakeRegistration;
use Modules\Schoolviser\Entities\CourseGroup;
use Modules\Schoolviser\Entities\Course;
use Modules\Schoolviser\Repositories\TermRepository;
use Modules\Schoolviser\Repositories\AcademicYearRepository;
use Modules\Schoolviser\Entities\AcademicYear;


use Delgont\Core\Entities\Any;

class TertiaryOverviewController extends Controller
{
    public function __construct(
        protected AcademicYearRepository $academicYearRepo
    ){

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($intakeuuid = null)
    {
        $company = company();
        $term = term();

        $academicYear = app(AcademicYearRepository::class)->company($company->id)->getCurrentYear();

        $total_recent_registrations = IntakeRegistration::whereDate('created_at', today())->count();

        // Student statistics by gender
        $studentsGenderCounts = IntakeRegistration::current()
        ->join('students', 'students.id', '=', 'intake_registrations.student_id')
        ->selectRaw("
            COUNT(*) as total_students,
            SUM(CASE WHEN students.gender = 'female' THEN 1 ELSE 0 END) as total_female,
            SUM(CASE WHEN students.gender = 'male' THEN 1 ELSE 0 END) as total_male
        ")
        ->first();

        $studentsPerCourse = Course::whereCompanyId($company->id)->withCount(['students as students_count' => function($q) {
            $q->whereHas('currentIntakeRegistration');
        }])->get();

        $studentsPerCourseGroup = CourseGroup::active()
        ->withCount(['students as students_count' => function($q) {
            $q->whereHas('currentIntakeRegistration');
        }])
        ->pluck('students_count', 'name')
        ->toArray();


        $totalRegistrationsPerIntake = app(TermRepository::class)->company($company->id)->getTotalRegistrationsPerIntake();



        return view('schoolviser::tertiary.students.overview', compact(
            'studentsGenderCounts',
            'studentsPerCourse',
            'totalRegistrationsPerIntake',
            'academicYear'
        ));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('student::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('student::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('student::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
