<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Perent;
use App\Models\Student;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = Perent::withCount('students')->paginate(10);
        return (request()->expectsJson()) ? response()->json($parents) : 'view';
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
    public function store(Request $request, $student_id)
    {
        if ($student_id) {
            $student = Student::findOrFail($student_id);

            $parent = new Perent;
            $parent->surname = $request->surname;
            $parent->other_names = $request->other_names;
            $parent->ocupation = $request->ocupation;
            $parent->phone_one = $request->phone_one;
            $parent->email = $request->email;
            $parent->relationship = $request->relationship;

            $parent->save();

            $student->parents()->attach($parent->id);

        } else {
            # code...
        }

        return back()->withInput();
        
    }

    /**
     * Display the specified parent info.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parent = Perent::findOrFail($id);
        return $parent;
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
        Perent::destroy($id);
        return back();
    }
}
