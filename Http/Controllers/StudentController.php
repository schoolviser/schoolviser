<?php

namespace Modules\Schoolviser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

# Models
use Modules\Schoolviser\Entities\Student;
use Modules\Schoolviser\Entities\TermlyRegistration;
use Modules\Schoolviser\Entities\YearGroup;
use Module\Schoolviser\AcademicYear;

use Modules\Schoolviser\Jobs\GenerateAccessNumbersJob;

use Modules\Schoolviser\Entities\Clazz;
//use App\Fee;
//use App\Group;

use Modules\Schoolviser\Http\Requests\StoreStudentRequest;
use Modules\Schoolviser\Http\Requests\UpdateStudentPersonalInfoRequest;
use Modules\Schoolviser\Http\Requests\UpdateTermlyRegistrationRequest;


//use App\Option;
//use App\Semester;
use PDF;

use Delgont\Core\Entities\Any;

//Exports
//use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Schoolviser\Entities\Term;

use Modules\Schoolviser\Exports\SecondaryStudentTemplateExport;

# Imports
use Modules\Schoolviser\Imports\SecondaryStudentImport;

use Modules\Schoolviser\Repositories\TermlyRegistrationRepository;
use Modules\Schoolviser\Repositories\ClazzRepository;
use Modules\Schoolviser\Repositories\AcademicYearRepository;
use Modules\Schoolviser\Repositories\SecondaryStudentRepository;

# Services
use Modules\Schoolviser\Services\SecondaryStudentService;
use Modules\Schoolviser\Services\TermlyRegistrationService;

use Modules\Schoolviser\Cache\CacheKeys\TermlyRegistrationCacheKeys;
use Modules\Schoolviser\Cache\CacheKeys\SecondaryStudentCacheKeys;


class StudentController extends Controller
{

    public function __construct(
        protected TermlyRegistrationRepository $termlyRegistrationRepository, 
        protected SecondaryStudentRepository $studentRepository,
        protected SecondaryStudentService $studentService,
        protected TermlyRegistrationService $termlyRegistrationService
        )
    {

        $this->middleware('current.term')->only(['index', 'store', 'updatePersonalInfo', 'updateAcademicInfo']);
    }
     /**
     * Display a listing of current students
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        #Get the current term
        $term = term();
        $company = company();
        $page = request()->input('page') ?? 1;

        #Get the students that belong to the current term
        $students = $this->termlyRegistrationRepository->company($company->id)->fromCache()->getPaginatedRegistrations($term->id, 15, $page);

        log_activity([
            'action'     => 'viewed.students',
            'company_id' => $company->id,
            'message'    => auth()->user()->name . " view students information listing ....",
            'visibility' => 'company_admin',
        ]);

        return (request()->expectsJson()) ? response()->json($students) : view('schoolviser::students.index', compact('students', 'term'));
    }

    /**
     * Show page for adding student
     */
    public function create()
    {
        $company = company();

        $clazzes = app(ClazzRepository::class)->company($company->id)->getClazzes();
        $academicYear = app(AcademicYearRepository::class)->company($company->id)->getCurrentYear();
        
        $yearGroups = YearGroup::all();

        return view('schoolviser::students.create', compact('clazzes','academicYear', 'yearGroups'));
    }

    public function store(StoreStudentRequest $request)
    {
        $request->validated();
        $companyId = company()->id;
        $term = term();

        $data = $this->studentService->company($companyId)->createStudent($request);

        log_activity([
            'action'     => 'created.registered.student',
            'company_id' => $companyId,
            'new'        => $data,
            'old' => $data,
            'subject'    => $data->student,
            'message'    => auth()->user()->name . " add & registered new student with reg reference ".$data->registration->uuid,
            'visibility' => 'company_admin',
        ]);

        TermlyRegistrationCacheKeys::clearPaginatedRegistrationCache($companyId, $term->id, 15, 100);
        
        // Dispatch the job to generate access numbers for this company
        GenerateAccessNumbersJob::dispatch($companyId);


        return ($request->expectsJson()) ? response()->json([
            'success' => true,
            'data' => [
                'student' => $student
            ]
        ]) : back()->withInput()->with('success', 'Student added or registered successfully');
    }



      /**
     * Display the specified student info.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = company();

        $student = $this->studentRepository->company($company->id)->fromCache()->getStudentProfile($id);

        log_activity([
            'action'     => 'viewed.student.profile',
            'company_id' => $company->id,
            'new'        => $student,
            'old' => $student,
            'subject'    => $student,
            'message'    => auth()->user()->name . " viewed student profile with reference ".$student->uuid,
            'visibility' => 'company_admin',
        ]);

        return (request()->expectsJson()) ? response()->json([
            'student' => $student
        ]) : view('schoolviser::students.profile', compact('student'));
    }


    /**
     * Update a student's personal information.
     *
     * This method validates the incoming request data, retrieves the target student
     * from the repository (scoped to the current company), and delegates the update
     * operation to the student service. After updating, it logs the activity and
     * clears relevant termly registration cache keys to ensure fresh data.
     *
     * @param \Modules\Schoolviser\Http\Requests\UpdateStudentPersonalInfoRequest $request
     *        The validated request containing updated student personal info fields.
     * @param int|string $student_id
     *        The unique identifier of the student to update.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *         Returns a JSON response when the request expects JSON, otherwise
     *         redirects back with a success message.
     *
     * Side Effects:
     * - Logs an activity entry for auditing.
     * - Clears paginated registration cache for the current term.
     */
    public function updatePersonalInfo(UpdateStudentPersonalInfoRequest $request, $student_id)
    {
        $data = $request->validated();
        
        $company = company();
        $term = term();

        $student = $this->studentRepository->company($company->id)->fromCache()->getStudentMinimal($student_id);

        $updated = $this->studentService
        ->company($company->id)
        ->after('updatePersonalInfo', function($student, $data) use ($company, $term){
            log_activity([
                'action'     => 'updated.student.personalinfo',
                'company_id' => $company->id,
                'subject'    => $student,
                'message'    => auth()->user()->name . " updated students personal information with reference ".$student->uuid,
                'visibility' => 'company_admin',
            ]);
            TermlyRegistrationCacheKeys::clearPaginatedRegistrationCache($company->id, $term->id, 15, 100);
        })->updatePersonalInfo($student, $data);

        return ($request->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Student personal information updated....!'
        ]) : back()->with('success', 'Student personal information updated....!');
    }


    public function syncFees($id)
    {
        $registrations =  TermlyRegistration::where('student_id', $id)->with('student')->get();

        foreach ($registrations as $registration) {
            # code...
            $registration->fees()->detach();
            $fees = Fee::where('year', $registration->year)->whereTerm($registration->term)->whereResidence($registration->residence)
            ->where('new_or_continuing', $registration->new_or_continuing)->whereGender($registration->student->gender)->where('clazz_id', $registration->clazz_id)->get();

            foreach ($fees as $fee) {
                # code...
                $registration->fees()->attach($fee->id);
            }
        }
    }


    /**
     * Delete student
     */
    public function destroy($id)
    {
        TermlyRegistration::destroy($id);
        return (request()->route()->named('students.profile')) ? redirect('students') : back();
    }

    /**
     * Get trashed students
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $students = Student::onlyTrashed()->get();
        return response()->json($students);
    }



    public function archived()
    {
        return Student::onlyArchived()->get();
    }

    public function archive($id)
    {
        $student = Student::find($id);
        $student->archive();
        return (request()->expectsJson()) ? response()->json(['success' => true, ['message' => 'Student successfully archived']]) : redirect('students');
    }



    public function updateAcademicInfo(UpdateTermlyRegistrationRequest $request, $termly_registration_id, $student_id)
    {
        $request = $request->validated();
        
        $company = company();

        $registration = $this->termlyRegistrationRepository->company($company->id)->getRegistration($termly_registration_id);
        $student = $this->studentRepository->company($company->id)->fromCache()->getStudentMinimal($student_id);


        if($registration->locked){
            abort(403, 'You can not update this registration because it is locked. Please contact the administrator if you want to make changes to this registration');
        }

        $updated = $this->termlyRegistrationService
        ->company($company->id)
        ->after('updateAcademicInfo', function($termlyRegistration, $data) use($company, $student){
            log_activity([
                'action'     => 'updated.student.personalinfo',
                'company_id' => $company->id,
                'subject'    => $termlyRegistration,
                'message'    => auth()->user()->name . " updated students personal information with reference ".$student->uuid,
                'visibility' => 'company_admin',
            ]);
        })
        ->updateRegistration($student, $registration, $request);

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Registration details updated successfully ......!'
        ]) : back()->with('success', 'Registration details updated successfully ......!');
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

        $student = $this->studentRepository->company($company->id)->fromCache()->getStudentMinimal($id);


        $this->studentService->company($company->id)
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


    /**
     * Display students study history
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function studyHistory($id)
    {
        $student = Student::findOrFail($id);

        return $termlyRegistrations = TermlyRegistration::whereStudentId($id)->with([
            'hostel'
        ])->orderBy('created_at', 'asc')->get();


        return (request()->expectsJson()) ? response()->json([
            'student' => $student
        ]) : view('dashboard.students.study.history.index', compact('student', 'termlyRegistrations'));
    }


    /**
     * Export Students information
     */
    public function export($year, $term)
    {
        return Excel::download(new StudentsExport($year, $term), $year.'Term'.$term.'students.xlsx');
    }

    public function registerStudent(\Modules\Schoolviser\Http\Requests\RegisterSecondaryStudentRequest $request, $studentuuid)
    {
        $company = company();
        $student = $this->studentRepository->company($company->id)->getStudentMinimal($studentuuid);

        // Merge student_id into validated request
        $request->merge([
            'student_id' => $student->id,
        ]);

        // Now you can use $request->validated() safely
        $data = $request->validated();

        $this->studentService->company($company->id)->registerStudent($student, $data);

        return back()->with('success', 'Student registered sucessfully .....!');
    }


     /**
     * Display a listing of unregistered students.
     * @return Renderable
     */
    public function unregistered()
    {
        $page = request()->get('page', 1);
        $term = term();
        $academic_years = [];
        $company = company();
        $clazzes = clazzes();

        $students = $this->studentRepository->company($company->id)->fromCache()->getPaginatedTermUnregisteredStudents($term->id, 15, $page);

        return view('schoolviser::students.unregistered_students', compact('students','term', 'clazzes'));
    }

    public function searchUnregistered(Request $request)
    {
        $term = term();
        $company = company();
        $query = $request->input('query'); // from GET

        $students = $this->studentRepository
            ->company($company->id)
            ->searchTermUnregisteredStudents($term->id, $query);

        // If request expects partial view (AJAX with header or param)
        if ($request->ajax() || $request->hasHeader('X-Partial-View')) {
            return response()->json([
                'html' => view('schoolviser::students.partials._unregistered_students_table', compact('students', 'term'))->render()
            ]);
        }

        // Otherwise return full view
        return view('schoolviser::students.partials._unregistered_students_table', compact('students', 'term'));
    }




    public function lockRegistration($termly_registration_id)
    {
        $companyId = company()->id;

        $registration = $this->termlyRegistrationRepository->company($companyId)->getRegistration($termly_registration_id);

        $updated = $this->termlyRegistrationService->company($companyId)->lockRegistration($registration);

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Registration locked successfully ......!'
        ]) : back()->with('success', 'Registration locked successfully ......!');
    }

    public function unlockRegistration($termly_registration_id)
    {
        $companyId = company()->id;

        $registration = $this->termlyRegistrationRepository->company($companyId)->getRegistration($termly_registration_id);

        $updated = $this->termlyRegistrationService->company($companyId)->unlockRegistration($registration);

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Registration unlocked successfully ......!'
        ]) : back()->with('success', 'Registration unlocked successfully ......!');
    }
    public function importRegistration()
    {
        $company = company();
        $term = term();
        Excel::import(new \Modules\Schoolviser\ImportsSecondaryStudentImport($term, $company->id), $request->file('file'));

        $ignored = SecondaryStudentImport::ignoredStudents();
        if (!empty($ignored)) {
            // Save to log, DB, or show in UI
            \Log::warning('Ignored students during import', $ignored);
        }

        $summary = SecondaryStudentImport::summary();

        return back()->with('success', "Import complete: {$summary['imported']} students registered, {$summary['ignored']} ignored.")
                    ->with('ignoredDetails', $summary['details']);

    }

    public function importSecondaryStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $company = company();
        $term = Term::current()->firstOrFail();

        Excel::import(new SecondaryStudentImport($term, $company->id), $request->file('file'));

        $summary = SecondaryStudentImport::summary();

        \Modules\Schoolviser\Cache\CacheKeys\TermlyRegistrationCacheKeys::clearPaginatedRegistrationCachedData($company->id, $term->id, 15, 300);

        return back()
            ->with('success', "Import complete: {$summary['imported']} students registered, {$summary['ignored']} ignored.")
            ->with('ignoredDetails', $summary['details']);
    }

    public function downloadTemplate()
    {
        $company = company(); // tenant context helper
        return Excel::download(new SecondaryStudentTemplateExport($company->id), 'secondary_students_template.xlsx');
    }



}
