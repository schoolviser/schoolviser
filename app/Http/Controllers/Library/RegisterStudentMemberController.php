<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Library\LibraryMember;


class RegisterStudentMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::current()->isNotLibraryMember('libraryMember')->with(['currentTermlyRegistration'])->paginate(400);
        return view('dashboard.library.members.students.register.index', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, $id)
    {
        $request->validate([
            'access_number' => 'required|unique:members,access_number'
        ]);

        $libraryMember = new LibraryMember;

        $libraryMember->joined_on = now();
        $libraryMember->access_number = $request->access_number;
        $libraryMember->member_type = Student::class;
        $libraryMember->member_id = $id;

        $libraryMember->save();

        return back()->withInput()->with('created', 'Student reistered successfully ...!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
