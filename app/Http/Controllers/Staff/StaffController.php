<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Department\Department;
use App\Models\Employee\LevelOfEducation;
use App\Models\Employee\EmployeePosition;


use Maatwebsite\Excel\Facades\Excel;

use App\Imports\EmployeeImport;

class StaffController extends Controller
{
    /**
     * Display a listing of staff members.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff =  Employee::with(['position', 'departments'])->orderBy('created_at', 'desc')->paginate();

        return (request()->expectsJson()) ? response()->json([
            'staff' => $staff
        ]) : view('dashboard.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.staff.create');
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
            'work_number' => 'nullable|unique:employees,work_number',
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'gender' => 'required',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'required',
            'nationality' => 'required',
            'photo' => 'nullable||mimes:jpeg,png,jpg|max:2048'
        ]);


        $employee = new Employee;
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->gender = $request->gender;
        $employee->date_of_birth = $request->date_of_birth;
        $employee->marital_status = $request->marital_status;
        $employee->nationality = $request->nationality;
        $employee->home_address = $request->home_address;
        $employee->current_address = $request->current_address;
        $employee->email = $request->email;
        $employee->primary_phone = $request->primary_phone;
        $employee->other_phone = $request->other_phone;
        $employee->work_number = $request->work_number;
        $employee->level_of_education_id = $request->level_of_education;
        $employee->employee_position_id = $request->position;
        $employee->photo  = ($request->hasFile('photo')) ? config('schoolviser.public_storage', 'storage').request()->photo->store('employees', 'public') : null;

        $employee->save();

        ($request->department) ?  $employee->departments()->attach($request->department) : '';


        return back()->withInput()->with('created', 'Employee created successfully...');
    }

    /**
     * Display the specified staff profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = Employee::with(['departments', 'position','user'])->withLeft()->findOrFail($id);

        return (request()->expectsJson()) ? response()->json([
            'staff' => $staff
        ]) :view('dashboard.staff.show', compact('staff'));
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
        Employee::destroy($id);
        return back()->with('deleted', 'Employee deleted successfully');
    }

    /**
     * Create authentication details for staff member.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createUserAccount(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|min:3|max:20|unique:users,name',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6|max:30|confirmed'
        ]);

        $staff = Employee::findOrfail($id);

        $staff->user()->create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return back()->withInput();
    }

    
    /**
     * Show a listing of deleted staff members.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $staff =  Employee::with(['position', 'departments'])->orderBy('created_at', 'desc')->onlyTrashed()->paginate();
        return view('dashboard.staff.trash', compact('staff'));
    }

    public function restore($id)
    {
        $staff = Employee::withTrashed()->whereId($id)->first()->restore();
        return back()->with('restored', 'Staff member restored successfully');
    }

     /**
     * Show a listing of staff who left the organisation.
     *
     * @return \Illuminate\Http\Response
     */
    public function left()
    {
        $staff =  Employee::with(['position', 'departments'])->orderBy('created_at', 'desc')->onlyLeft()->paginate();
        return view('staff.left', compact('staff'));
    }

    /**
     * Mark employee as left
     */
    public function markAsLeft(Request $request, $id)
    {
        $request->validate([
            'date' => 'nullable|date'
        ]);

        Employee::whereId($id)->first()->markAsLeft($request->date);

        return back()->withInput();
    }

    public function unMarkAsLeft($id)
    {
        Employee::whereId($id)->withLeft()->first()->unMarkAsLeft();
        return back();
    }


    /**
     * Update employee photo
     */
    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required||mimes:jpeg,png,jpg|max:2048'
        ]);


        Employee::whereId($id)->update([
            'photo' => request()->photo->store('employees')
        ]);

        return ($request->expectsJson()) ? response()->json(['success' => true, 'message' => 'Photo updated successfully'], 200) : back()->withInput()->with('updated', 'Avator changed successfully');
    }

    public function updatePersonalInfo(Request $request, $id)
    {
        Employee::whereId($id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'nin' => $request->nin,
            'primary_phone' => $request->phone,
            'other_phone' => $request->other_phone,
            'date_of_birth' => $request->dob,
            'email' => $request->email,
            'religion' => $request->religion,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
        ]);

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Employee personal info updated successfully....'
        ]) : back()->withInput()->with('updated', 'Employee personal info updated successfully....');
    }

    public function updateWorkInfo(Request $request, $id)
    {
        $request->validate([
            'hire_date' => 'required|date'
        ]);

        $employee = Employee::whereId($id)->firstOrFail();

        $employee->hire_date = $request->hire_date;
        $employee->employee_position_id = $request->position;
        $employee->save();

        $employee->departments()->sync($request->departments);

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Employee work info updated successfully'
        ]) : back()->withInput()->with('updated', 'Employee work info updated successfully');
    }

    public function import(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'file' => 'required'
            ]);
    
            Excel::import(new EmployeeImport, request()->file('file'));
            return back()->withInput()->with('created', 'Employee information imported successfully');
        }
        return view('dashboard.staff.import');
    }

}
