<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Entities\Term;
use App\Entities\AcademicYear;

use App\Repositories\TermRepository;


class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page = request()->query('page') ?? 1;

        $terms = app(TermRepository::class)->fromCache()->paginate(15,$page);
        $years = AcademicYear::all();
        return (request()->expectsJson()) ? response()->json($terms, 200) : view('admin.settings.terms.index', compact('terms', 'years'));
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
        $max_end_date =  Term::max('end_date') ?? '2007-01-01';

        $request->validate([
            'year' => 'required',
            'term' => 'required',
            'start_date' => 'required|date|after_or_equal:'.$max_end_date,
            'end_date' => 'required|date|after:start_date',
            'next_term_start_date' => 'nullable|date'
        ], [
            'start_date.after_or_equal' => 'There is already a session btn '.request('start_date').' and '.$max_end_date
        ]);

        $term = new Term;

        $term->year = $request->year;
        $term->term = $request->term;
        $term->academic_year_id = $year->id ?? null;
        $term->start_date = $request->start_date;
        $term->end_date = $request->end_date;
        $term->next_term_start_date = $request->next_term_start_date;

        $term->save();

        return back()->withInput()->with('created', 'Term session created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $term = Term::findOrFail($id);

        $years = AcademicYear::all();

        return view('admin.settings.terms.show', compact('term','years'));
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

        //$year = AcademicYear::whereId($request->year)->firstOrFail();

        $term = Term::findOrFail($id);

        $term->year = $request->year;
        $term->term = $request->term;
        //$term->academic_year_id = $year->id;
        $term->start_date = $request->start_date;
        $term->end_date = $request->end_date;
        $term->next_term_start_date = $request->next_term_start_date;

        $term->save();


        return back()->withInput()->with('updated', 'Term info updated successfully .....');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
