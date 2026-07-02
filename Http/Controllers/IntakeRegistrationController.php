<?php

namespace Modules\Schoolviser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Schoolviser\Services\IntakeRegistrationService;

use Modules\Schoolviser\Repositories\IntakeRegistrationRepository;
use Modules\Schoolviser\Repositories\TertiaryStudentReposiory;


class IntakeRegistrationController extends Controller
{
    public function __construct(
        protected IntakeRegistrationService $intakeRegistrationService,

        protected IntakeRegistrationRepository $intakeRegistrationRepo,
        protected TertiaryStudentReposiory $tertiaryStudentRepo,

    )
    {

    }

    /**
     * Get all intake registrations
     */
    public function index($intakeid = null)
    {
        $company = company();
        $intake = $intakeid ? term($intakeid) : term();
        $page = request('page') ?? 1;
        $registrations = $this->intakeRegistrationRepo->company($company->id)->fromCache()->getIntakePaginatedRegistrations($intake->id, 15, $page);
        return view('schoolviser::tertiary.registrations.index', compact('registrations'));
    }

    /**
     * Lock registration
     */
    public function lockRegistration(Request $request, $id) 
    {
        $company = company();
        
        $intakeRegistration = $this->intakeRegistrationRepo->company($company->id)->fromCache()->getIntakeRegistration($id);

        $student = $this->tertiaryStudentRepo->company($company->id)->fromCache()->getStudentById($intakeRegistration->student_id);

        $this->intakeRegistrationService->company($company->id)->setStudentIds([$student->id, $student->uuid])->lockRegistration($intakeRegistration, function($registration){
            log_activity([
                'action'    => 'locked.student.registration',
                'company_id' => company()?->id,
                'message'   => auth()->user()->name." locked student registration ",
                'visibility' => 'company_admin',
            ]);
        });

        return back()->with('success', 'Intake registration locked successfully .....!');
    }

    public function unLockRegistration(Request $request, $id) 
    {
        $company = company();
        
        $intakeRegistration = $this->intakeRegistrationRepo->company($company->id)->fromCache()->getIntakeRegistration($id);

        $student = $this->tertiaryStudentRepo->company($company->id)->fromCache()->getStudentById($intakeRegistration->student_id);

        $this->intakeRegistrationService->company($company->id)->setStudentIds([$student->id, $student->uuid])->unLockRegistration($intakeRegistration, function($registration){
            log_activity([
                'action'    => 'unlocked.student.registration',
                'company_id' => company()?->id,
                'message'   => auth()->user()->name." unlocked student registration ",
                'visibility' => 'company_admin',
            ]);
        });

        return back()->with('success', 'Intake registration unlocked successfully .....!');
    }

    
}
