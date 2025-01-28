<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Entities\Course;
use App\Entities\Department;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $courses =  Course::with(['department'])->paginate(7);
        $departments = Department::all();

        return (request()->expectsJson()) ? response()->json([
            'data' => $courses
        ]) : view('admin.courses.index', compact('courses', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:255|unique:courses,name',
            'short_name' => 'nullable|string|max:10|unique:courses,abbr',
            'duration' => 'nullable|integer|min:1|max:10',
            'description' => 'nullable|string|max:1000',
            'department' => 'nullable|exists:departments,id',
        ]);

        $course = new Course;
        $course->name = $request->name;
        $course->abbr = $request->short_name;
        $course->duration = $request->duration;
        $course->description = $request->description;
        $course->department_id = $request->department;

        $course->save();

        return back()->withInput()->with('created', 'Course created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the course or throw a 404 error
        $course = Course::findOrFail($id);

        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:255|unique:courses,name,' . $id,
            'short_name' => 'nullable|string|max:10|unique:courses,abbr,' . $id,
            'duration' => 'nullable|integer|min:1|max:10',
            'description' => 'nullable|string|max:1000',
            'department' => 'nullable|exists:departments,id',
        ]);

        // Update the course details
        $course->update([
            'name' => $validatedData['name'],
            'abbr' => $validatedData['short_name'] ?? null,
            'duration' => $validatedData['duration'] ?? null,
            'description' => $validatedData['description'] ?? null,
            'department_id' => $validatedData['department'] ?? null,
        ]);

        // Redirect back with a success message
        return back()->with('updated', 'Course details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
