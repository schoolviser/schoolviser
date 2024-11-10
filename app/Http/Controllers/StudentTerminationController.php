<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;

class StudentTerminationController extends Controller
{
    /**
     * Display a listing of terminated students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function terminate()
    {
        //
    }

    public function expel(Request $request, $id)
    {
        $student = Student::find($id);
        $student->expel($request->reason);

        return back();
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
}
