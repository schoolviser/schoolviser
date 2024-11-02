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

//use Modules\Student\Repositories\TermlyRegistrationRepository;
use App\Repositories\ClazzRepository;


//use Modules\Student\Repositories\SemesterRegistrationRepository;
use Modules\Course\Entities\Course;


use App\Entities\Term;


use App\Jobs\PopulateStudentSemesterTotal;

use Illuminate\Support\Facades\Cache;



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
        //Get total students of the current term
       // $registrations = (config('schoolviser.type') == 'secondary' || config('schoolviser.type') == 'primary') ? app(TermlyRegistrationRepository::class)->fromCache()->current()->getRegistrations() : app(SemesterRegistrationRepository::class)->fromCache()->current()->getRegistrations() ;

        //$studentsPerCourse = (config('schoolviser.type') == 'secondary' || config('schoolviser.type') == 'primary') ? app(ClazzRepository::class)->fromCache()->current()->getTotalRegistrationsPerClazz() :  Course::withCount(['students' => function($studentQuery){
            //$studentQuery->whereHas('currentSemesterRegistration');
       // }])->get()->mapWithKeys(function($item){
           // return [($item['abbr']) ? $item['abbr'] : $item['name'] => $item['students_count']];
       // })->toArray();;


        //$registrations = new Any([
          //  'total' => 0,
          //  'female' => ($registrations) ? $registrations->filter(function($registration){
          //      return $registration->student->gender == 'female';
          //  })->count() : 0,
          //  'male' => ($registrations) ? $registrations->filter(function($registration){
          //      return $registration->student->gender == 'male';
          //  })->count() : 0
      //  ]);


        //$totalTeachers = app(TeacherRepository::class)->fromCache()->count();

        //$totalUsers = 30;

        //$expenses = ExpenseTransaction::current('term')->get()->sum('amount');

        $studentsPerCourse = [];

      


        return view('admin.index');
    }
}
