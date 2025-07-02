<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $terms = app(TermRepository::class)->fromCache()->getAll();
        return response()->json($terms, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $max_end_date = Term::max('end_date') ?? '2007-01-01';

        $validatedData = $request->validate([
            'year' => 'required',
            'term' => 'required',
            'start_date' => 'required|date|after_or_equal:' . $max_end_date,
            'end_date' => 'required|date|after:start_date',
            'next_term_start_date' => 'nullable|date'
        ], [
            'start_date.after_or_equal' => "There is already a session between {$request->start_date} and {$max_end_date}"
        ]);

        $term = Term::create($validatedData);

        return response()->json(['message' => 'Term session created successfully', 'term' => $term], 200);
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

        return request()->expectsJson()
            ? response()->json(['term' => $term, 'years' => $years], 200)
            : view('admin.settings.terms.show', compact('term', 'years'));
    }

     /**
     *
     * @return \Illuminate\Http\Response
     */
    public function current()
    {
        $term = app(TermRepository::class)->getCurrentTerm();

       return response()->json($term, 200);
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
        $term = Term::findOrFail($id);

        $validatedData = $request->validate([
            'year' => 'required',
            'term' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'next_term_start_date' => 'nullable|date'
        ]);

        $term->update($validatedData);

        return request()->expectsJson()
            ? response()->json(['message' => 'Term info updated successfully', 'term' => $term], 200)
            : back()->withInput()->with('updated', 'Term info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $term = Term::findOrFail($id);
        $term->delete();

        return request()->expectsJson()
            ? response()->json(['message' => 'Term deleted successfully'], 200)
            : back()->with('deleted', 'Term deleted successfully');
    }
}
