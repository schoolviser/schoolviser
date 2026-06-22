<?php

namespace Modules\Student\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Student\Entities\IntakeRegistration;
use Modules\Student\Entities\Student;
use Modules\Student\Entities\YearGroup;
use App\Entities\CourseGroup;
use App\Entities\Course;
use App\Entities\AcademicYear;
use App\Entities\Term;

use Delgont\Core\Entities\Any;

use Illuminate\Support\Facades\Cache;

use Delgont\Armor\Events\AuditActivityLogged;

use Modules\Student\Repositories\IntakeRegistrationRepository;


class TertiaryStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $semester = term();
        $registrations =  app(IntakeRegistrationRepository::class)->getCurrentPaginatedRegistrations();

        $students = $registrations->getCollection()->transform(function($item, $key){
            return new Any([
                'id' => $item->id,
                'uuid' => $item->uui,
                'student_id' => $item->student->id,
                'term_id' => $item->term_id,
                'name' => $item->student->first_name.' '.$item->student->last_name,
                'regno' => $item->student->regno,
                'access_number' => $item->student->access_number,
                'gender' => $item->student->gender,
                'course' => ($item->student->course) ? $item->student->course : null,
                'photo' => $item->student->photo,
                'courseGroup' => $item->student->courseGroup,
                'residence' => $item->residence,
                'new_or_continuing' => $item->new_or_continuing,
                'year' => $item->year,
                'semester' => $item->semester,
                'term' => $item->term,
            ]);
        });

        $students = $registrations->setCollection($students);

        return response()->json($students, 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $request->validate([
            'regno' => 'nullable|unique:students,regno',
            'school_pay_code' => 'nullable|unique:students,school_pay_code',
            'photo' => 'nullable|mimes:jpeg,bmp,png',
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'nullable|email|unique',
            'dob' => 'required|date',
            'entry_date' => 'nullable|date',
            'country' => 'nullable|max:100',
            'residence' => 'required'
        ]);

        $student = new Student;
        $student->regno = $request->regno;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->nationality = $request->country;
        $student->date_of_birth = $request->dob;
        $student->course_id = $request->course;
        $student->year_group_id = $request->year_group;
        $student->course_group_id = $request->course_group;
        $student->city = $request->city;
        $student->village = $request->village;
        $student->school_pay_code = $request->school_pay_code;
        $student->phone = $request->phone;

        $saved = $student->save();

        $registration = new IntakeRegistration;
        $registration->term_id = term()->id;
        $registration->student_id = $student->id;
        $registration->residence = $request->residence;
        $registration->new_or_continuing = $request->new_or_continuing ?? 'new';
        $registration->hostel_id = $request->hostel;
        $registration->semester = $request->semester ?? 1;
        $registration->year = $request->year ?? 1;
        $registration->balance_carried_forword = $request->balance_carried_forword;

        $registration->save();

        $student = new Any([
            'id' => $student->id,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'gender' => $student->gender,
            'nationality' => $student->nationality,
            'registration' => $registration
        ]);

       event(
            new AuditActivityLogged(
                auth()->user(),
                'Student Registered',
                "<a href='" . route('users.show', ['id' => auth()->user()->id]) . "'>" . auth()->user()->name . "</a> registered a student - " . $student->first_name . ' ' . $student->last_name . ". <a href='" . route('students.show', $student->id) . "'>Click here</a> to view student details.",
                [
                    'method'     => $request->method(),
                    'url'        => $request->fullUrl(),
                    'ip'         => $request->ip(),
                    'user_agent' => $request->header('User-Agent')
                ],
                $student,
                null
            )
        );

        return ($request->expectsJson()) ? response()->json([
            'success' => true,
            'data' => [
                'student' => $student
            ]
        ]) : back()->withInput()->with('created', 'Student added or registered successfully')->with('student', $student);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $student = Student::with(['course', 'currentIntakeRegistration', 'courseGroup','intakeRegistrations' => function($intakeRegistrationsQuery){
            $intakeRegistrationsQuery->with('term');
        }])->where('uuid', $id)->orWhere('id', $id)->firstOrFail();


        event(
            new AuditActivityLogged(
                auth()->user(),
                'Viewed Student',
                "<a href='" . route('users.show', ['id' => auth()->user()->id]) . "'>" . auth()->user()->name . "</a> viewed a student - " . $student->first_name . ' ' . $student->last_name . ". <a href='" . route('students.show', $student->id) . "'>Click here</a> to view student details.",
                [
                    'method'     => request()->method(),
                    'url'        => request()->fullUrl(),
                    'ip'         => request()->ip(),
                    'user_agent' => request()->header('User-Agent')
                ],
                $student,
                null
            )
        );

       return response()->json($student, 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return $student = Student::with(['course', 'currentIntakeRegistration'])->findOrFail($id);

        return view('student::edit');
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $registration =  IntakeRegistration::findOrFail($id);

        $registration->delete();

         event(
            new AuditActivityLogged(
                auth()->user(),
                'Deleted Student Registration Info',
                "<a href='" . route('users.show', ['id' => auth()->user()->id]) . "'>" . auth()->user()->name . "</a> Deleted Student Registration Info -<a href='" . route('students.show', $registration->student_id) . "'>Click here</a> to view student details.",
                [
                    'method'     => request()->method(),
                    'url'        => request()->fullUrl(),
                    'ip'         => request()->ip(),
                    'user_agent' => request()->header('User-Agent')
                ],
                $registration,
                $registration
            )
        );
        return (request()->route()->named('students.profile')) ? redirect('students') : back();
    }


    /**
     * Display a listing of unregistered students.
     * @return Renderable
     */
    public function unregistered()
    {
        $semester = term();
        $students = Student::whereDoesntHave('currentSemesterRegistration')->with(['course', 'semesterRegistrations'])->paginate();
        $yearGroups = YearGroup::withCount('students')->get();
        $courses = Course::all();
        $academic_years = AcademicYear::all();

        return view('student::tertiary.unregistered_students', compact('students','yearGroups','courses', 'academic_years'));
    }



    public function enroll(Request $request, $student_id)
    {
        $request->validate([
            //'residence' => 'required',
            'hostel' => 'nullable',
            'room' => 'nullable',
            'semester' => 'required'
        ]);

        $student = Student::whereId($student_id)->firstOrFail();
        //$semester = Term::where('academic_year_id', $request->academic_year)->where('term', $request->semester)->firstOrFail();

        $registration = new IntakeRegistration;
        $registration->residence = 'boarding';
        $registration->new_or_continuing = 'new';
        $registration->hostel_id = $request->hostel;
        $registration->room_id = $request->room;
        $registration->term_id = $request->semester;
        $registration->student_id = $student->id;

        if(is_null($student->course_id)){
            $student->course_id = $request->course;
            $student->save();
        }

        $registration->save();

        return back()->withInput()->with('created', 'Student enrolled successfully ..');


    }


     /**
     * Update student personal information
     */
    public function updatePersonalInfo(Request $request, $id)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date',
            'phone' => 'nullable',
            'regno' => 'nullable',
        ]);



        $student = Student::whereId($id)->firstOrFail();


        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->date_of_birth = $request->dob;
        $student->nationality = $request->nationality;
        $student->address = $request->address;
        $student->regno = $request->regno;
        $student->phone = $request->phone;
        $student->nin = $request->nin;
        $student->city = $request->city;

        $student->save();

        event(
            new AuditActivityLogged(
                auth()->user(),
                'Updated Student Personal Info',
                "<a href='" . route('users.show', ['id' => auth()->user()->id]) . "'>" . auth()->user()->name . "</a> Updated Student Personal Info - " . $student->first_name . ' ' . $student->last_name . ". <a href='" . route('students.show', $student->id) . "'>Click here</a> to view student details.",
                [
                    'method'     => request()->method(),
                    'url'        => request()->fullUrl(),
                    'ip'         => request()->ip(),
                    'user_agent' => request()->header('User-Agent')
                ],
                $student,
                null
            )
        );

        return back()->withInput()->with('updated', 'Student Personal Info Updated Successfully ....');
    }

    public function updateAcademicInfo(Request $request, $id)
    {
        $registration = IntakeRegistration::current()->whereStudentId($id)->first();

        $student = Student::findOrFail($id);

        $registration->residence = $request->residence;
        $registration->new_or_continuing = $request->new_or_continuing;
        $registration->year = $request->year;
        $registration->semester = $request->semester;


        $student->course_id = $request->course;
        $student->regno = $request->regno;
        $student->admission_number = $request->admission_number;

        $registration->save();
        $student->save();

        event(
            new AuditActivityLogged(
                auth()->user(),
                'Updated Student Academic Info',
                "<a href='" . route('users.show', ['id' => auth()->user()->id]) . "'>" . auth()->user()->name . "</a> Updated Student Academic Info - " . $student->first_name . ' ' . $student->last_name . ". <a href='" . route('students.show', $student->id) . "'>Click here</a> to view student details.",
                [
                    'method'     => request()->method(),
                    'url'        => request()->fullUrl(),
                    'ip'         => request()->ip(),
                    'user_agent' => request()->header('User-Agent')
                ],
                $registration,
                $registration
            )
        );

        return back()->withInput()->with('updated', 'Academic info updated successfully ...');
    }


    /**
     * Search for students in the current intake registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
    public function search($query)
    {

        // Get the current term
        $term = term();

        $students = IntakeRegistration::current()
            ->where('term_id', $term->id)
            ->whereHas('student', function ($studentQuery) use ($query) {
                $studentQuery->where('access_number', 'LIKE', "%{$query}%")
                    ->orWhere('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%");
            })
            ->with(['student.course', 'student.yearGroup', 'student.courseGroup'])
            ->get()->map(function($item){
                return new Any([
                    'id' => $item->id,
                    'uuid' => $item->uui,
                    'student_id' => $item->student->id,
                    'term_id' => $item->term_id,
                    'name' => $item->student->first_name.' '.$item->student->last_name,
                    'regno' => $item->student->regno,
                    'access_number' => $item->student->access_number,
                    'gender' => $item->student->gender,
                    'course' => ($item->student->course) ? $item->student->course : null,
                    'photo' => $item->student->photo,
                    'courseGroup' => $item->student->courseGroup,
                    'residence' => $item->residence,
                    'new_or_continuing' => $item->new_or_continuing,
                    'year' => $item->year,
                    'semester' => $item->semester,
                    'term' => $item->term,

                ]);
            });

        return response()->json($students, 200);
    }


    public function perCourse($course_id, $intake_id)
    {
        $course = Course::where('uuid',$course_id)->firstOrFail();

        $registrations = IntakeRegistration::current()->with(['student' => function($studentQuery) use ($course){
            $studentQuery->whereCourseId($course->id)->with(['course','yearGroup', 'courseGroup']);;
        }])->paginate(20);

        $students = $registrations->getCollection()->transform(function($item, $key){
            if($item->student){
                return new Any([
                    'id' => $item->student->id,
                    'first_name' => $item->student->first_name,
                    'last_name' => $item->student->last_name,
                    'regno' => $item->student->regno,
                    'access_number' => $item->student->access_number,
                    'gender' => $item->student->gender,
                    'course' => $item->student->course,
                    'photo' => $item->student->photo,
                    'yearGroup' => $item->student->yearGroup,
                    'courseGroup' => $item->student->courseGroup,
                    'registration' => new Any([
                        'id' => $item->id,
                        'residence' => $item->residence,
                        'new_or_continuing' => $item->new_or_continuing,
                        'year' => $item->year,
                        'semester' => $item->semester,
                        'meta' => $item->meta
                    ])
                ]);
            }
            return null;
        })->filter();
        $students = $registrations->setCollection($students);

        return view('student::tertiary.per_course', compact('students', 'course'));

    }

    public function getGenderBased($gender)
    {

        $registrations =  app(IntakeRegistrationRepository::class)->getGenderBasedRegistrations($gender);

        $students = $registrations->getCollection()->transform(function($item, $key){
            if($item->student){
                return new Any([
                    'id' => $item->student->id,
                    'names' => $item->student->first_name.' '.$item->student->last_name,
                    'regno' => $item->student->regno,
                    'access_number' => $item->student->access_number,
                    'gender' => $item->student->gender,
                    'course' => $item->student->course,
                    'photo' => $item->student->photo,
                    'yearGroup' => $item->student->yearGroup,
                    'courseGroup' => $item->student->courseGroup,
                    'registration' => new Any([
                        'id' => $item->id,
                        'residence' => $item->residence,
                        'new_or_continuing' => $item->new_or_continuing,
                        'year' => $item->year,
                        'semester' => $item->semester,
                        'meta' => $item->meta
                    ])
                ]);
            }
            return null;
        })->filter();

        $students = $registrations->setCollection($students);
        return response()->json($students, 200);
    }

}
