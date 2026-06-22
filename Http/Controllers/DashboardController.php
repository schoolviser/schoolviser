<?php

namespace Modules\Schoolviser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;


class DashboardController extends Controller
{
    
    public function index()
    {
        return view('index');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $intake = term();

        $registrations =  IntakeRegistration::current()->with(['student'])->get();

        $overview = new Any([
            'total_students' => $registrations->count(),
            'total_female' => $registrations->filter(function($registration){
                return $registration->student->gender == 'female';
            })->count(),
            'total_male' => $registrations->filter(function($registration){
                return $registration->student->gender == 'male';
            })->count()
        ]);

        $studentsPerCourseGraphData = Course::whereHas('students')->withCount(['students' => function($studentQuery){
            $studentQuery->whereHas('currentIntakeRegistration');
        }])->get()->mapWithKeys(function($item){
            return [($item['abbr']) ? $item['abbr'] : $item['name'] => $item['students_count']];
        })->toArray();


        return view('admin.index', compact('overview', 'studentsPerCourseGraphData'));
    }
}
