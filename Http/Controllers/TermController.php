<?php

namespace Modules\Schoolviser\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Modules\Schoolviser\Http\Requests\StoreTermRequest;
use Modules\Schoolviser\Http\Requests\UpdateTermRequest;

use Modules\Schoolviser\Entities\Term;
use Modules\Schoolviser\Entities\AcademicYear;

use Modules\Schoolviser\Repositories\TermRepository;
use Modules\Schoolviser\Repositories\AcademicYearRepository;

use Modules\Schoolviser\Services\TermService;


class TermController extends Controller
{

    protected AcademicYearRepository $academicYearRepository;
    protected TermRepository $termRepository;
    protected TermService $termService;

    public function __construct(AcademicYearRepository $academicYearRepository, TermRepository $termRepository, TermService $termService)
    {
        $this->academicYearRepository = $academicYearRepository;
        $this->termRepository = $termRepository;
        $this->termService = $termService;
        //Ensure schooltype is set

        //Ensure Current academic year is set
        $this->middleware('current.academic.year');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $companyId = company()->id;
        
        $terms = $this->termRepository->company($companyId)->fromCache()->getAllTerms();

        $years = $this->academicYearRepository->company($companyId)->fromCache()->getAllYears();

        log_activity([
            'action'     => 'viewed.terms',
            'company_id' => $companyId,
            'message'    => auth()->user()->name . " viewed terms page ",
            'visibility' => 'company_admin',
        ]);
        
        return request()->expectsJson()
            ? response()->json(['terms' => $terms, 'years' => $years], 200)
            : view('schoolviser::terms.index', compact('terms', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreTermRequest  $request)
    {
        
        $companyId = company()->id;

        $max_end_date = Term::whereCompanyId($companyId)->max('end_date') ?? '2007-01-01';

        $overlapping = $this->termService
            ->company($companyId)
            ->checkIfDatesOverLapExisting($request->start_date, $request->end_date);

        if ($overlapping) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => [
                        'date_range' => ['The selected date range overlaps with an existing term session.']
                    ]
                ], 422);
            }

            return back()
                ->withErrors(['date_range' => 'The selected date range overlaps with an existing term session.'])
                ->withInput();
        }

        $term = $this->termService->company($companyId)->createTerm($request);

        log_activity([
            'action'     => 'create.term',
            'company_id' => $companyId,
            'new'        => $term,
            'subject'    => $term,
            'message'    => auth()->user()->name . " created new term ",
            'visibility' => 'company_admin',
        ]);

        return request()->expectsJson()
            ? response()->json(['message' => 'Term session created successfully', 'term' => $term], 201)
            : back()->withInput()->with('created', 'Term session created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $term = Term::where('uuid', $id)->firstOrFail();
        
        $years = AcademicYear::all();

        return request()->expectsJson()
            ? response()->json(['term' => $term, 'years' => $years], 200)
            : view('admin.settings.terms.show', compact('term', 'years'));
    }

    public function edit($id)
    {
        $companyId = company()?->id;

        $term = $this->termRepository->company($companyId)->fromCache()->getTerm($id);
        $years = $this->academicYearRepository->company($companyId)->fromCache()->getAllYears();

        return view('schoolviser::terms.edit', compact('term','years'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermRequest $request, $id)
    {
        $companyId = company()->id;
        $term = $this->termRepository->company($companyId)->fromCache()->getTerm($id);

        $updated = $this->termService->company($companyId)->updateTerm($term, $request);

        log_activity([
            'action'     => 'update.term',
            'company_id' => $companyId,
            'old'        => $term,
            'new'        => $updated,
            'subject'    => $updated,
            'message'    => auth()->user()->name . " updated term ",
            'visibility' => 'company_admin',
        ]);

        return request()->expectsJson()
            ? response()->json(['message' => 'Term session updated successfully', 'term' => $updated], 200)
            : back()->withInput()->with('success', 'Term session updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyId = company()?->id;
        $term = $this->termRepository->company($companyId)->fromCache()->getTerm($id);

        $deleted = $this->termService->company($companyId)->deleteTerm($term);

        log_activity([
            'action'     => 'deleted.term',
            'company_id' => $companyId,
            'old'        => $term,
            'new'        => $term,
            'subject'    => $term,
            'message'    => auth()->user()->name . " delete term with id ".$term->uuid,
            'visibility' => 'company_admin',
        ]);

        return request()->expectsJson()
            ? response()->json(['message' => 'Term deleted successfully'], 200)
            : back()->with('deleted', 'Term deleted successfully');
    }
}
