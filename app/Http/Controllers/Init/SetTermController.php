<?php

namespace App\Http\Controllers\Init;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Entities\Term;
use App\Entities\AccountingPeriod;

class SetTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('init.set_term');
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
        $term->start_date = $request->start_date;
        $term->end_date = $request->end_date;
        $term->next_term_start_date = $request->next_term_start_date;

        $term->save();

        return back()->withInput()->with('created', 'Term session created successfully');
    }

    public function storePeriod(Request $request)
    {
        $max_end_date =  AccountingPeriod::max('end_date') ?? '2007-01-01';

        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date|after_or_equal:'.$max_end_date,
            'end_date' => 'required|date|after:start_date',
        ], [
            'start_date.after_or_equal' => 'There is already a session btn '.request('start_date').' and '.$max_end_date
        ]);

        $term = new AccountingPeriod;

        $term->name = $request->name;
        $term->start_date = $request->start_date;
        $term->end_date = $request->end_date;

        $term->save();

        return back()->withInput()->with('created', 'Period session created successfully');
    }


}
