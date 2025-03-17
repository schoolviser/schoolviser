<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Delgont\Core\Entities\Any;

/**
 * Repos
 */
use App\Repository\TermRepository;

use App\Repositories\ClazzRepository;

use App\Entities\Term;


use App\Jobs\PopulateStudentSemesterTotal;

use Illuminate\Support\Facades\Cache;
use Exception;

use App\Schoolviser;

use Modules\Student\Entities\IntakeRegistration;
use App\Entities\Course;

use Modules\User\Entities\User;



class DashboardController extends Controller
{
    public function __construct()
    {
       //$this->middleware(['licensed']);
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
