<?php

namespace App\Http\Controllers\Academics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Academics\Routine;
use App\Models\Academics\Subject;
use App\Models\Clazz;


use App\Support\Models\Any;


class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.academics.timetables.index');
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
        $routine = new Routine;

        $routine->clazz_id = $request->clazz;
        $routine->stream_id = $request->stream;
        $routine->subject_id = $request->subject;
        $routine->start_time = $request->starting_time;
        $routine->end_time = $request->ending_time;
        $routine->day = $request->day;

        $routine->term_id = term()->id;

        $routine->save();

        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clazz = Clazz::findOrFail($id);
        $routines = Routine::whereHas('clazz', function($clazzQuery) use ($id){
            $clazzQuery->whereId($id);
        })->with(['subject','clazz','term','stream'])->get()->groupBy('day');

        $timetable = new Any([
            'clazz' => $clazz,
            'mon' => (isset($routines['mon'])) ? $this->organized($routines['mon']) : null,
            'tue' => (isset($routines['tue'])) ? $this->organized($routines['tue']) : null,
            'wed' => (isset($routines['wed'])) ? $this->organized($routines['wed']) : null,
            'thur' => (isset($routines['thur'])) ? $this->organized($routines['thur']) : null,
            'fri' => (isset($routines['fri'])) ? $this->organized($routines['fri']) : null,
            'sat' => (isset($routines['sat'])) ? $this->organized($routines['sat']) : null,
            'sun' => (isset($routines['sun'])) ? $this->organized($routines['sun']) : null,
        ]);

        return view('dashboard.academics.timetables.show', compact('timetable'));
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
        //
    }


    protected function organized($routines)
    {
        return collect($routines)->map(function($item, $key){
           return $item;
        });
    }
}
