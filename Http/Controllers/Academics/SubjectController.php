<?php

namespace Modules\Schoolviser\Http\Controllers\Academics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Schoolviser\Entities\Subject;

# Respositories
use Modules\Schoolviser\Repositories\SubjectRepository;

class SubjectController extends Controller
{
    public function __construct(
        protected SubjectRepository $subjectRepository
    ){

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = company();
        $page = request()->get('page', 1);

        $subjects = $this->subjectRepository->company($company->id)->fromCache()->getPaginatedSubjects(15, $page);
        return view('schoolviser::academics.subjects.index', compact('subjects'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'level' => 'required',
        ]);

        $subject = new Subject;

        $subject->name = $request->name;
        $subject->level = $request->level;
        $subject->core = $request->core ?? '0';
        $subject->subsidiary = $request->subsidiary ?? '0';

        $subject->save();

        return (request()->expectsJson()) ? response()->json([
            'message' => 'Subject add successfully',
            'success' => true,
            'actions' => [
                'view' => 'place the view subject url here',
                'delete' => 'place the delete url here'
            ]
        ]) : back()->withInput()->with('created', 'Subject created successfully ....');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $subject = Subject::with(['papers'])->findOrFail($id);
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
        Subject::whereId($id)->delete();

        return (request()->expectsJson()) ? response()->json([
            'message' => 'Subject deleted successfully ..',
            'success' => true
        ]) : back()->with('deleted', 'Subjuect deleted successfully ...');
    }
}
