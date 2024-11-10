<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hostel;
use App\Models\Building;
use App\Term;
use App\Student;




class HostelController extends Controller
{

    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.f3
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $hostels = Hostel::with(['building'])->withCount(['rooms', 'termlyRegistrations'])->get();
       $buildings = Building::whereNull('building_id')->get();
       return (request()->expectsJson()) ? response()->json(['hostels' => $hostels]) : view('dashboard.hostels.index', compact('hostels','buildings'));
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
        $hostel = new Hostel;
        $hostel->name = $request->name;
        $hostel->gender = $request->gender;
        $hostel->address = $request->address;
        $hostel->year = $request->year;
        $hostel->term = $request->term;

        $hostel->save();

        return (request()->expectsJson()) ? response()->jpsn(['success' => true, 'message' => 'Hostel created sucessfully']) : back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $hostel = Hostel::withCount(['terms'])->findOrFail($id);

        $students = Student::current()->with('currentRegistration')->ofHostel($id)->paginate(10);


        return (request()->expectsJson()) ? response()->json([
            'hostel' => $hostel, 'students' => $students
        ]) : view('hostels.show', compact(['hostel', 'students']));
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
        $updated = Hostel::whereId($id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'year' => $request->year,
            'term' => $request->term
        ]);

        return (request()->expectsJson()) ? response()->jpsn(['success' => true, 'message' => 'Hostel details updated sucessfully']) : back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        app(HostelRepository::class)->destroy($id);
        return (request()->expectsJson()) ? response()->jpsn(['success' => true, 'message' => 'Hostel deleted sucessfully']) : back();
    }


    public function addStudents($id)
    {
        return view('hostels.add_students');
    }

    public function addStudent($id, $student_id)
    {
        $hostel = Hostel::findOrFail($id);

        $hostel = $hostel->students()->attach($student_id, [
            'yeat' => option('current_year'),
            'term' => option('current_term')
        ]);

        return (request()->expectsJson()) ? response()->jpsn(['success' => true, 'message' => 'student added to hostel sucessfully']) : back();
    }


    public function removeStudent($id, $student_id)
    {
        $hostel = Hostel::findOrFail($id);

        $hostel = $hostel->students()->detach($student_id);

        return (request()->expectsJson()) ? response()->jpsn(['success' => true, 'message' => 'student added to hostel sucessfully']) : back();
    }


}
