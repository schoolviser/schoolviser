<?php

namespace Modules\Schoolviser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;

use Modules\Schoolviser\Repositories\AcademicYearRepository;
use Modules\Schoolviser\Services\AcademicYearService;


class AcademicYearController extends Controller
{
    protected AcademicYearRepository $academicYearRepository;
    protected AcademicYearService $academicYearService;

    public function __construct(AcademicYearRepository $academicYearRepository, AcademicYearService $academicYearService)
    {
        $this->academicYearRepository = $academicYearRepository;
        $this->academicYearService = $academicYearService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = company()->id;

        //setTenantSetting('school_type', 'tertiary', 'schoolviser_setup');
        getTenantSettings('schoolviser_setup');

        $years = $this->academicYearRepository->company($companyId)->getAllYears();

        return view('schoolviser::years.index', compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schoolviser::create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $companyId = auth()->user()->default_company_id;

        $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:30',
                Rule::unique('academic_years')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                }),
            ],
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
        ]);


        $overlapping = $this->academicYearService
            ->company($companyId)
            ->checkIfDatesOverLapExisting($request->start_date, $request->end_date);

        if ($overlapping) {
            return back()
                ->withErrors(['date_range' => 'The selected date range overlaps with an existing academic year.'])
                ->withInput();
        }

        $year = $this->academicYearService->company($companyId)->createYear($request);

        log_activity([
            'action'     => 'create.academic.year',
            'company_id' => company()?->id,
            'new'        => $year,
            'subject'    => $year,
            'message'    => auth()->user()->name . " created new academic year ",
            'visibility' => 'company_admin',
        ]);

        return back()->with('success', 'Academic year created successfully')->with('year', $year);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('schoolviser::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('schoolviser::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
