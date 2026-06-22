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
//use Maatwebsite\Excel\Facades\Excel;

use Modules\Schoolviser\Entities\Term;

use Modules\Schoolviser\Repositories\TermlyRegistrationRepository;
use Modules\Schoolviser\Repositories\ClazzRepository;
use Modules\Schoolviser\Repositories\AcademicYearRepository;
use Modules\Schoolviser\Repositories\StudentRepository;

use Modules\Schoolviser\Services\StudentService;
use Modules\Schoolviser\Services\TermlyRegistrationService;

use Modules\Schoolviser\Cache\CacheKeys\TermlyRegistrationCacheKeys;


class StudentController extends Controller
{
    protected TermlyRegistrationRepository $termlyRegistrationRepository;
    protected StudentService $studentService;
    protected StudentRepository $studentRepository;
    protected TermlyRegistrationService $termlyRegistrationService;


    public function __construct(
        TermlyRegistrationRepository $termlyRegistrationRepository, 
        StudentRepository $studentRepository,
        StudentService $studentService,
        TermlyRegistrationService $termlyRegistrationService
        )
    {
        $this->termlyRegistrationRepository = $termlyRegistrationRepository;
        $this->studentRepository = $studentRepository;
        $this->studentService = $studentService;
        $this->termlyRegistrationService = $termlyRegistrationService;

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
        $registrations = $this->termlyRegistrationRepository->company($company->id)->fromCache()->getPaginatedRegistrations($term->id, 15, $page);

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
                //'yearGroup'     => $item->student->yearGroup,
                'nin'           => $item->student->nin,
                'nationality'   => $item->student->nationality,
                'registration'  => new Any([
                    'id'               => $item->id,
                    'uuid'               => $item->uuid,
                    'residence'        => $item->residence,
                    'new_or_continuing'=> $item->new_or_continuing,
                    'meta'             => $item->meta,
                ]),
                'clazz' => new Any([
                    'id' => $item->clazz->id,
                    'uuid' => $item->clazz->uuid,
                    'name' => $item->clazz->name,
                    'code' => $item->clazz->code,
                ])
            ]);
        });

        $students = $registrations->setCollection($students);

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


    public function updatePersonalInfo(UpdateStudentPersonalInfoRequest $request, $student_id)
    {
        $request->validated();
        
        $company = company();
        $term = term();

        $oldStudent = $this->studentRepository->company($company->id)->fromCache()->getStudentProfile($student_id);

        $updated = $this->studentService->company($company->id)->updatePersonalInfo($oldStudent, $request);

        log_activity([
            'action'     => 'updated.student.personalinfo',
            'company_id' => $company->id,
            'new'        => $updated,
            'old' => $oldStudent,
            'subject'    => $oldStudent,
            'message'    => auth()->user()->name . " updated students personal information with reference ".$oldStudent->uuid,
            'visibility' => 'company_admin',
        ]);

        TermlyRegistrationCacheKeys::clearPaginatedRegistrationCache($company->id, $term->id, 15, 100);

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



    public function updateAcademicInfo(UpdateTermlyRegistrationRequest $request, $termly_registration_id)
    {
        $request = $request->validated();
        
        $companyId = company()->id;

        $registration = $this->termlyRegistrationRepository->company($companyId)->getRegistration($termly_registration_id);

        if($registration->locked){
            abort(403, 'You can not update this registration because it is locked. Please contact the administrator if you want to make changes to this registration');
        }

        $updated = $this->termlyRegistrationService->company($companyId)->updateRegistration($registration, $request);

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Registration details updated successfully ......!'
        ]) : back()->with('success', 'Registration details updated successfully ......!');
    }


    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);

        Student::whereId($id)->update([
            'photo' => 'storage/'.request()->photo->store('students', 'public')
        ]);

        return ($request->expectsJson()) ? response()->json(['success' => true, 'message' => 'Photo updated successfully'], 200) : back()->withInput()->with('updated', 'Avator changed successfully');
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


     /**
     * Display a listing of unregistered students.
     * @return Renderable
     */
    public function unregistered()
    {
        $term = term();
        $students = Student::whereDoesntHave('currentTermlyRegistration')->paginate();
        $academic_years = AcademicYear::all();

        return view('student::unregistered_students', compact('students','academic_years'));
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



}
