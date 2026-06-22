<?php
namespace Modules\Schoolviser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

use Modules\Schoolviser\Entities\IntakeRegistration;
use Modules\Schoolviser\Entities\Student;
use Modules\Schoolviser\Entities\YearGroup;
use Modules\Schoolviser\Entities\CourseGroup;
use Modules\Schoolviser\Entities\Course;
use Modules\Schoolviser\Entities\AcademicYear;
use Modules\Schoolviser\Entities\Term;

use Delgont\Core\Entities\Any;

use Illuminate\Support\Facades\Cache;

use Modules\Schoolviser\Repositories\IntakeRegistrationRepository;
use Modules\Schoolviser\Repositories\AcademicYearRepository;
use Modules\Schoolviser\Repositories\CourseRepository;
use Modules\Schoolviser\Repositories\StudentRepository;

use Modules\Schoolviser\Cache\CacheKeys\IntakeRegistrationCacheKeys;
use Modules\Schoolviser\Cache\CacheKeys\StudentCacheKeys;

use Modules\Schoolviser\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;


class TertiaryStudentController extends Controller
{


    public function __construct(
        protected IntakeRegistrationRepository $intakeRegistrationRepository,
        protected StudentRepository $studentRepository
        )
    {

        //$this->middleware(['is.TertiarySchool']);

        /**
         * Ensure School Periods are setup.
         * Periods - Academic Year and Term(INtake) are required for most of the students management operations, 
         * so we will check if they are setup before allowing access to the students management pages.    
         */
        $this->middleware(function ($request, $next) {
            $company = company();
            $intakeUuid = $request->route('intakeuuid');

            if ($intakeUuid) {
                $intake = term($intakeUuid);

                if (!$intake) {
                    // Get all other intakes for this company/year to show in the 404 page
                    $otherIntakes = app(TermRepository::class)
                        ->company($company->id)
                        ->getAll();

                    return response()->view('schoolviser::errors.tertiary.intake_not_found', [
                        'intakeUuid' => $intakeUuid,
                        'otherIntakes' => $otherIntakes,
                    ], 404);
                }
            } else {
                // Get current academic year
                $academicYear = app(AcademicYearRepository::class)
                    ->company($company->id)
                    ->getCurrentYear();
                if(!$academicYear) {
                    // Require the user to setup the current acaddemi year
                    return response()->view('schoolviser::years.setup');
                }

                // Get current term (inake)
                $term = term();

                if (!$term) {
                    return response()->view('schoolviser::terms.setup', compact('academicYear'));
                }
            }

            return $next($request);
        })->only(['index']);
    }
    /**
     * Show students of specific intake.
     * @return Renderable
     */
    public function index($intakeuuid = null)
    {
        // Detect current page from query string (default 1)
        $page = request()->get('page', 1);

        // 2. Fetch registrations + term
        [$registrations, $term] = $intakeuuid
            ? [$this->intakeRegistrationRepository->fromCache()->company(company()->id)->getIntakePaginatedRegistrations($intakeuuid, 15, $page), term($intakeuuid)]
            : [$this->intakeRegistrationRepository->fromCache()->company(company()->id)->getCurrentPaginatedRegistrations(15, $page), term()];

        // Transform students
        $students = $registrations->getCollection()->transform(function ($item) {
            return new Any([
                'id'            => $item->student->id,
                'first_name'    => $item->student->first_name,
                'last_name'     => $item->student->last_name,
                'regno'         => $item->student->regno,
                'access_number' => $item->student->access_number,
                'gender'        => $item->student->gender,
                'course'        => $item->student->course,
                'photo'         => $item->student->photo,
                'yearGroup'     => $item->student->yearGroup,
                'courseGroup'   => $item->student->courseGroup,
                'nin'           => $item->student->nin,
                'nationality'   => $item->student->nationality,
                'registration'  => new Any([
                    'id'               => $item->id,
                    'residence'        => $item->residence,
                    'new_or_continuing'=> $item->new_or_continuing,
                    'year'             => $item->year,
                    'semester'         => $item->semester,
                    'meta'             => $item->meta,
                ]),
            ]);
        });

        $students = $registrations->setCollection($students);

        log_activity([
            'action'    => 'viewed.students.information',
            'company_id' => company()?->id,
            'message'   => auth()->user()->name." viewed students information ",
            'visibility' => 'company_admin',
        ]);

        return view('schoolviser::tertiary.students.index', compact('students', 'term'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $academic_year = app(AcademicYearRepository::class)->company(company()->id)->getCurrentAcademicYear();
        $yearGroups = YearGroup::withCount('students')->get();

        $courseGroups = CourseGroup::all();

        $courses = app(CourseRepository::class)->company(company()->id)->getAllCourses();

        return view('schoolviser::tertiary.students.create', compact('academic_year','yearGroups', 'courses','courseGroups'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

       $request->validate([
            'regno'           => 'nullable|unique:students,regno',
            'school_pay_code' => 'nullable|unique:students,school_pay_code',
            'photo'           => 'nullable|mimes:jpeg,bmp,png',
            'first_name'      => 'required|min:3|max:50',
            'last_name'       => 'required|min:3|max:50',
            'email'           => 'nullable|email|unique:students,email',
            'dob'             => 'nullable|date',
            'entry_date'      => 'nullable|date',
            'country'         => 'nullable|max:100',
            'phone'           => [
                'nullable',
                'max:20',
                Rule::unique('students', 'phone')->where(function ($query) {
                    return $query->where('company_id', company()->id);
                }),
            ],
        ]);

        $company = company();

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
        $student->company_id = $company->id;

         if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'student_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('students/photos', $filename);
            $student->photo = $filename;
        }

        $saved = $student->save();

        $registration = new IntakeRegistration;
        $registration->term_id = term()->id;
        $registration->academic_year_id = term()->academic_year_id;
        $registration->student_id = $student->id;
        $registration->residence = $request->residence;
        $registration->new_or_continuing = $request->new_or_continuing ?? 'new';
        $registration->hostel_id = $request->hostel;
        $registration->semester = $request->semester ?? 1;
        $registration->year = $request->year ?? 1;
        //$registration->balance_carried_forword = $request->balance_carried_forword;
        $registration->company_id = $company->id;

        $registration->save();


       //Log activity
        log_activity([
            'action'    => 'added.student',
            'company_id' => company()?->id,
            'message'   => auth()->user()->name." added new students ",
            'visibility' => 'company_admin',
        ]);

       //Clear Cache
       IntakeRegistrationCacheKeys::clearCurrentPaginatedRegistrationsCache(15, 50, company()->id);

       // Add student to DelxeroMkt Hotspot If enable and students user profile is set

       $students_user_profile = getTenantSetting('students_user_profile', null, 'schoolviser_mkt');

       if($students_user_profile)
        {
            \Modules\Schoolviser\Jobs\CreateStudentHotspotAccountJob::dispatch($student, $company, $students_user_profile);
        }

        \Modules\Schoolviser\Jobs\SyncCourseEnrollmentStatsJob::dispatch($student, $company, $students_user_profile);



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
        $student = app(StudentRepository::class)->fromCache()->company(company()->id)->getTertiaryStudentProfile($id);

        $courses = app(CourseRepository::class)->company(company()->id)->getAllCourses();

        //Log activity
        log_activity([
            'action'    => 'viewed.student.profile',
            'company_id' => company()?->id,
            'message'   => auth()->user()->name." viewed student profile ".$student->uuid,
            'visibility' => 'company_admin',
        ]);

        return (request()->expectsJson()) ? response()->json([
            'student' => $student
        ]) : view('schoolviser::tertiary.students.profile', compact('student','courses'));
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
         
        return (request()->route()->named('students.profile')) ? redirect('students') : back();
    }


    /**
     * Display a listing of unregistered students.
     * @return Renderable
     */
    public function unregistered()
    {
        $intake = term();
        $company = company();

        //$students = $this->studentRepository->company($company->id)->getUnregisteredTertiaryStudents($intake);

        $students = Student::whereCompanyId($company->id)->whereDoesntHave('currentIntakeRegistration')->with(['course', 'intakeRegistrations' => function($q){
            $q->with('term');
        },'courseGroup'])->paginate();

        $courseGroups = CourseGroup::all();
        $courses = Course::all();
        $academic_years = AcademicYear::all();

        log_activity([
            'action'    => 'viewed.unregistered.students.information',
            'company_id' => company()?->id,
            'message'   => auth()->user()->name." viewed  unregistered students information ",
            'visibility' => 'company_admin',
        ]);

        return view('schoolviser::tertiary.students.unregistered_students', compact('students','courseGroups','courses', 'academic_years'));
    }


    public function enroll(Request $request, $student_id)
    {

        $request->validate([
            'term' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'new_or_continuing' => 'required',
        ]);

        $company = company();
        $student = Student::whereId($student_id)->firstOrFail();
        $term = term($request->term);

        // Then enforce uniqueness manually:
        $exists = IntakeRegistration::where('company_id', company()->id)
            ->where('term_id', $term->id)
            ->where('semester', $request->semester)
            ->where('year', $request->year)
            ->where('student_id', $student_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['term' => 'This student is already enrolled in the selected intake.']);
        }


        // Check if this term allows intake registrations

        $registration = new IntakeRegistration;
        $registration->new_or_continuing = $request->new_or_continuing;
        $registration->term_id = $term->id;
        $registration->academic_year_id = $term->academic_year_id;
        $registration->company_id = $company->id;

        $registration->semester = $request->semester;
        $registration->year = $request->year;
        $registration->student_id = $student->id;


        $registration->save();

        IntakeRegistrationCacheKeys::clearCurrentPaginatedRegistrationsCache(15, 50, company()->id);

        log_activity([
            'action'    => 'registered.student',
            'company_id' => company()?->id,
            'message'   => auth()->user()->name." registered student for intake ".$term->uuid,
            'visibility' => 'company_admin',
        ]);

        return back()->withInput()->with('success', 'Student enrolled successfully ..');

    }

    public function deregister($registration_id)
    {
        $registration = IntakeRegistration::findOrFail($registration_id);
        $registration->delete();

        return back()->with('success', 'Student deregistered successfully.');
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

       // log activity
        log_activity([
            'action'    => 'updated.student.personal.info',
            'company_id' => company()?->id,
            'message'   => auth()->user()->name." updated student personal info - <a href='" . route('tertiary.students.show', $student->id) . "'>Click here</a> to view student details.",
            'visibility' => 'company_admin',
        ]);

        //Clear Cache
        StudentCacheKeys::clearTertiaryStudentProfileCache(company()->id, $student->uuid);
        IntakeRegistrationCacheKeys::clearCurrentPaginatedRegistrationsCache(10, 1, company()->id);

        return back()->withInput()->with('success', 'Student Personal Info Updated Successfully ....');
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

        StudentCacheKeys::clearTertiaryStudentProfileCache(company()->id, $student->uuid);
        IntakeRegistrationCacheKeys::clearCurrentPaginatedRegistrationsCache(10, 1, company()->id);

        // log activity
        log_activity([
            'action'    => 'updated.student.academic.info',
            'company_id' => company()?->id,
            'subject' => $registration,
            'message'   => auth()->user()->name." updated student personal info - <a href='" . route('tertiary.students.show', $student->id) . "'>Click here</a> to view student details.",
            'visibility' => 'company_admin',
        ]);




        return back()->withInput()->with('success', 'Academic info updated successfully ...');
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
        $company = company();

        /*$students = IntakeRegistration::current()
            ->where('term_id', $term->id)
            ->whereHas('student', function ($studentQuery) use ($query) {
                $studentQuery->where('access_number', 'LIKE', "%{$query}%")
                    ->orWhere('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%");
            })
            ->with(['student.course', 'student.yearGroup', 'student.courseGroup'])
            ->paginate();*/

        $students = IntakeRegistration::whereCompanyId($company->id)->whereHas('student', function ($studentQuery) use ($query) {
                $studentQuery->where('access_number', 'LIKE', "%{$query}%")
                    ->orWhere('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%");
            })->whereTermId($term->id)
            ->with(['student.course', 'student.yearGroup', 'student.courseGroup'])
            ->paginate();

       

        // Return JSON response if the request expects JSON


        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $students,
                'message' => 'Search results retrieved successfully.'
            ], 200);
        }

        return $students;

        // Render the search results in the view
        return view('student::tertiary.search_results', compact('students', 'query'));
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

        return $students = $registrations->setCollection($students);
    }

    public function export(Request $request)
    {
        // Example: get company, term, course, gender from request
        $company = company();
        $term    = term();
        $course  = null;
        $gender  = null;

        // Pass them into StudentsExport
        return Excel::download(
            new StudentsExport($company, $term, $course, $gender),
            'students.xlsx'
        );
    }

}
