<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use App\Models\Employee\EmployeePosition;

class StaffPositionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','usertype:master|employee']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = EmployeePosition::withCount('members')->orderBy('created_at', 'desc')->paginate();
        return (request()->expectsJson(['positions' => $positions])) ? response()->json() : view('dashboard.staff.positions.index', compact('positions'));
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
            'name' => 'required|unique:employee_positions,name|min:3'
        ]);

        $position = new EmployeePosition;
        $position->name = $request->name;
        $position->save();

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
        EmployeePosition::whereId($id)->update([
            'name' => $request->name
        ]);

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmployeePosition::destroy($id);
        return back();
    }
}
