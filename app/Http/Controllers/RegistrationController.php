<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Registration;

use App\Models\Student;
use App\Models\Clazz;
use App\Models\TermlyRegistration;
use App\Fee;
use App\Group;

use App\Http\Requests\RegisterStudentRequest;


use App\Option;
use App\Semester;

use PDF;

use App\Support\Models\Any;

//Exports
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Term;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year = null)
    {
        return 'show number of students registered in that term, when registerring old student show the previous balance as well, register student using previous paramenters';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.students.registration.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function regieterNew(RegisterStudentRequest $request, $id = null)
    {
        $request->validated();

        $student = new Student;
        $student->regno = $request->regno;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->nationality = $request->country;
        $student->dob = $request->dob;

        $saved = $student->save();

        $term = Term::whereTerm($request->term)->where('year', $request->year)->first();

        $registration = new TermlyRegistration;
        $registration->student_id = $student->id;
        $registration->clazz_id = $request->clazz;
        $registration->residence = $request->residence;
        $registration->new_or_continuing = $request->new_or_continuing ?? 'new';
        $registration->hostel_id = $request->hostel ?? null;
        $registration->term_id = $term->id;

        $registration->save();


        return back()->withInput()->with('created', 'Student registered sucessfully');
    }

    public function regieterOld(Request $request, $id)
    {

       

        $term = term();

        $registration = new TermlyRegistration;
        $registration->student_id = $id;
        $registration->clazz_id = $request->clazz;
        $registration->residence = $request->residence;
        $registration->new_or_continuing = 'continuing';
        $registration->hostel_id = $request->hostel ?? null;
        $registration->term_id = $term->id;

        $registration->save();

        return back()->withInput()->with('created', 'Old Student registered sucessfully');
    }


    public function registered()
    {
        $currentRegistrations = TermlyRegistration::current()->with(['student'])->paginate();
        return view('dashboard.students.registration.registered', compact('currentRegistrations'));

    }


    /**
     * Get old term students.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function old()
    {
        $previousTerm = Term::previous()->first();

        $previousUnregisteredStudents = Student::with(['previousTermlyRegistration'])->whereDoesntHave('currentTermlyRegistration')->paginate();

        return view('dashboard.students.registration.old', compact('previousUnregisteredStudents','previousTerm'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Registration::with('student')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Registration::destroy($id);
        return back();
    }
}
