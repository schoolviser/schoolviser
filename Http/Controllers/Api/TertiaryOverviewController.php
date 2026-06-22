<?php

namespace Modules\Schoolviser\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Schoolviser\Entities\IntakeRegistration;
use Modules\Schoolviser\Entities\CourseGroup;
use Modules\Schoolviser\Entities\Course;

use Delgont\Core\Entities\Any;

class TertiaryOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $term_id = request('term_id') ?? term()->id;

        $registrations =  IntakeRegistration::ofTerm($term_id)->with(['student'])->get();
        $total_recent_registrations = IntakeRegistration::whereDate('created_at', today())->count();

        $studentsPerCourse = Course::whereHas('students')->withCount(['students' => function($studentQuery){
            $studentQuery->whereHas('currentIntakeRegistration');
        }])->get();

         $studentsPerCourseGroup = CourseGroup::active()->withCount(['students' => function($studentQuery){
            $studentQuery->whereHas('currentIntakeRegistration');
        }])->get()->mapWithKeys(function($item){
            return [$item['name'] => $item['students_count']];
        })->toArray();


        $overview = new Any([
            'id' => $term_id,
            'total_students' => $registrations->count(),
            'total_female' => $registrations->filter(function($registration){
                return $registration->student->gender == 'female';
            })->count(),
            'total_male' => $registrations->filter(function($registration){
                return $registration->student->gender == 'male';
            })->count(),
            'total_recent_registrations' => $total_recent_registrations,
            'students_per_course' => $studentsPerCourse->mapWithKeys(function($item){
                return [$item['name'] => $item['students_count']];
            })->toArray(),
            'students_per_course_group' => $studentsPerCourseGroup,
        ]);






        return response()->json([
            'overview' => $overview
        ], 200);

        return view('student::tertiary.overview', compact('overview','studentsPerCourse', 'studentsPerCourseGraphData', 'studentsPerCourseGroup', 'total_recent_registrations'));
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
