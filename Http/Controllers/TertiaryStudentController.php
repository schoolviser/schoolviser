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
use Modules\Schoolviser\Repositories\TertiaryStudentReposiory;

use Modules\Schoolviser\Services\TertiaryStudentService;

use Modules\Schoolviser\Cache\CacheKeys\IntakeRegistrationCacheKeys;
use Modules\Schoolviser\Cache\CacheKeys\TertiaryStudentCacheKeys;

# EXPORTS:
use Modules\Schoolviser\Exports\TertiaryStudentsExport;
use Modules\Schoolviser\Exports\SelectedTertiaryStudentExport;
use Maatwebsite\Excel\Facades\Excel;


class TertiaryStudentController extends Controller
{


    public function __construct(
        protected IntakeRegistrationRepository $intakeRegistrationRepository,
        protected TertiaryStudentReposiory $tertiaryStudentRepo,
        protected TertiaryStudentService $tertiaryStudentService

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
        $page = request('page') ?? 1;

        $term = $intakeuuid ? term($intakeuuid) : term();

        // 2. Fetch registrations + term
        $registrations = $this->intakeRegistrationRepository->fromCache()->company(company()->id)->getPaginatedIntakeRegistrations($term->id, 15, $page);

        // Transform students
        $students = $registrations->getCollection()->transform(function ($item) {
            return new Any([
                'id'            => $item->student->id,
                'uuid'            => $item->student->uuid,
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
    public function store(\Modules\Schoolviser\Http\Requests\StoreTertiaryStudentRequest $request)
    {
        $request->validated();

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
            $photoFile = $request->file('photo');

            $company = company($this->companyId);

            // Build path: {delxero_account_number}/avatars/students/{student_id}.{ext}
            $directory = $company->delxero_account_number . '/avatars/students';
            $extension = $photoFile->getClientOriginalExtension(); // e.g. jpg, jpeg, png
            $filename  = $student->id . '.' . $extension;

            // Store file in public disk
            $path = $photoFile->storeAs($directory, $filename, 'public');

            // Update student record with full path
            $student->photo = $path;
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
       IntakeRegistrationCacheKeys::clearPaginatedIntakeRegistrationsCachedData($company->id, $registration->term_id, 15, 50);

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
        
        $companyId = company()->id;
        $student =  $this->tertiaryStudentRepo->company($companyId)->fromCache()->getStudentProfile($id);

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
     * Get the unregistered students
     * @return Renderable
     */
    public function unregistered($intakeuuid = null)
    {
        $intake = $intakeuuid ? term($intakeuuid) : term();
        $company = company();

        $students = $this->tertiaryStudentRepo->company($company->id)->getPaginatedUnregisteredStudents($intake->id);

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


    /**
     * Register student into the intake
     */
    public function enroll(Request $request, $student_id)
    {
        $request->validate([
            'term_id'          => 'required',
            'year'             => 'required',
            'semester'         => 'required',
            'new_or_continuing'=> 'required',
        ]);

        $company = company();
        $student = $this->tertiaryStudentRepo->company($company->id)->getStudentById($student_id);
        $term    = term($request->term_id);

        // Append academic_year_id onto the request object
        $request->merge([
            'academic_year_id' => $term->academic_year_id,
        ]);

        // Pass the enriched request into the service
        $this->tertiaryStudentService
            ->company($company->id)
            ->register($student, $request, function ($registration, $student) {
                // Callback code, e.g. logging or cache clearing
            });
        return back()->with('success', 'Student registered successfully ......');
        
    }

    public function bulkEnroll(Request $request)
    {
        $request->validate([
            'student_ids'       => 'required|string', // comma-separated IDs
            'term_id'           => 'required|exists:terms,id',
            'semester'          => 'required|integer|min:1|max:2',
            'year'              => 'required|integer|min:1|max:5',
            'new_or_continuing' => 'required|in:new,continuing',
        ]);

        $company = company();
        $studentIds = explode(',', $request->student_ids);

        $term = term($request->term_id);


        foreach ($studentIds as $studentId) {
            $student = $this->tertiaryStudentRepo
                ->company($company->id)
                ->fromCache()
                ->getStudent($studentId);

            if (!$student) {
                continue; // skip invalid IDs
            }

            // Merge academic_year_id into request data
            $term = term($request->term_id);
            $data = $request->all();
            $data['academic_year_id'] = $term->academic_year_id;

            // Call your service register method
            $this->tertiaryStudentService
                ->company($company->id)
                ->register($student, new Request($data), function ($registration, $student) {
                    log_activity([
                        'action'     => 'bulk.enrolled.student',
                        'company_id' => company()?->id,
                        'message'    => auth()->user()->name." bulk enrolled student {$student->first_name} {$student->last_name}",
                        'visibility' => 'company_admin',
                    ]);
                });
        }

        return back()->with('success', 'Selected students enrolled successfully.');
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

        $company = company();
        $term = term();

        // Merge term_id into the request data
        $request = $request->merge(['term_id' => $term->id])->all();

        $student = $this->tertiaryStudentRepo->company($company->id)->fromCache()->getStudentById($id);

        $this->tertiaryStudentService->company($company->id)->updatePersonalInfo($student, $request, function($student){
            // Call backs
        });

       // log activity
        log_activity([
            'action'    => 'updated.student.personal.info',
            'company_id' => company()?->id,
            'message'   => auth()->user()->name." updated student personal info - <a href='" . route('tertiary.students.show', $student->id) . "'>Click here</a> to view student details.",
            'visibility' => 'company_admin',
        ]);

        return back()->withInput()->with('success', 'Student Personal Info Updated Successfully ....');
    }

    public function updateAcademicInfo(Request $request, $studentId, $intakeRegistrationId)
    {
        $company = company();

        $student = $this->tertiaryStudentRepo->company($company->id)->getStudent($studentId);
        $registration = $this->intakeRegistrationRepository->company($company->id)->getIntakeRegistration($intakeRegistrationId);

        // Validate if the registration belongs to the user and company
        if ($student->id == $registration->student_id) {
            // additional checks if needed
        }

        $data = $request->validate([
            'regno'             => 'nullable|unique:students,regno,' . $studentId . ',id,company_id,' . $company->id,
            'admission_number'  => 'nullable|unique:students,admission_number,' . $studentId . ',id,company_id,' . $company->id,
            'course'            => 'nullable|integer',
            'semester'          => 'nullable|integer',
            'year'              => 'nullable|integer',
            'new_or_continuing' => 'nullable|string',
            'residence'         => 'nullable|string',
        ]);


        $this->tertiaryStudentService
            ->company($company->id)
            ->updateAcademicInfo($student, $registration, $data, function($student, $registration){
                log_activity([
                    'action'    => 'updated.student.academic.info',
                    'company_id' => company()?->id,
                    'subject'   => $registration,
                    'message'   => auth()->user()->name." updated student",
                    'visibility'=> 'company_admin',
                ]);
            });

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

    /**
     * Export current students information
     */
    public function export(Request $request, $intakeid = null)
    {
        // Example: get company, term, course, gender from request
        $company = company();
        $term    = $intakeid ? term($intakeid) : term();
        $course  = null;
        $gender  = null;

        // Pass them into StudentsExport
        return Excel::download(
            new TertiaryStudentsExport($company, $term, $course, $gender),
            'students.xlsx'
        );
    }


    public function selectedStudentsExport(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|string',
        ]);

        $ids = explode(',', $request->student_ids);

        if (empty($ids)) {
            return back()->with('error', 'No students selected for export.');
        }

        return Excel::download(new SelectedTertiaryStudentExport($ids), 'selected_students.xlsx');
    }

    /**
     * Update students photo
     */
    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $term = term();
        $company = company();

        $student = $this->tertiaryStudentRepo->company($company->id)->getStudentById($id);

        $this->tertiaryStudentService->company(company()->id)
            ->setTerm($term)
            ->updatePhoto($student, $request->file('photo'), function ($student, $path) {
                log_activity([
                    'action'     => 'updated.student.photo',
                    'company_id' => company()?->id,
                    'message'    => auth()->user()->name." updated student photo for {$student->first_name} {$student->last_name}",
                    'visibility' => 'company_admin',
                ]);
            });

        return back()->with('success', 'Student photo updated successfully.');
    }


}
