<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\CourseGroup;
use Illuminate\Support\Facades\Validator;

class CourseGroupController extends Controller
{
    /**
     * Display a paginated list of course groups.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get paginated course groups with related course and student count
        $courseGroups = CourseGroup::with(['course', 'students'])->paginate(10);

        $courses = \App\Entities\Course::all();
        $terms = \App\Entities\Term::all();

        return (request()->expectsJson()) ?  response()->json([
            'data' => $courseGroups,
            'message' => 'Course groups retrieved successfully.'
        ], 200) : view('admin.courses.course_groups', compact('courseGroups', 'courses','terms'));
    }

    /**
     * Store a new course group in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_code' => 'nullable|string|max:10|unique:course_groups',
            'description' => 'nullable|string',
            'completes_on' => 'nullable|date',
            'course_id' => 'nullable|exists:courses,id',
            'term_id' => 'nullable|exists:terms,id',
        ]);

        // Create the course group
        $courseGroup = CourseGroup::create($request->all());

        // Eager load the 'course' relationship
        $courseGroup->load('course');

        // Return the course group with its course details
        return response()->json([
            'data' => $courseGroup,
            'message' => 'Course group created successfully.',
        ], 201);
    }



    /**
     * Display a specific course group.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Find the course group by ID or fail
        $courseGroup = CourseGroup::with(['course', 'students'])->find($id);

        if (!$courseGroup) {
            return response()->json([
                'message' => 'Course group not found.'
            ], 404);
        }

        return response()->json([
            'data' => $courseGroup,
            'message' => 'Course group retrieved successfully.'
        ], 200);
    }

    /**
     * Update an existing course group in the database.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Find the course group by ID
        $courseGroup = CourseGroup::find($id);

        if (!$courseGroup) {
            return response()->json([
                'message' => 'Course group not found.'
            ], 404);
        }

        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_code' => "nullable|string|max:10|unique:course_groups,short_code,$id",
            'description' => 'nullable|string',
            'completes_on' => 'nullable|date',
            'course_id' => 'nullable|exists:courses,id',
            'term_id' => 'nullable|exists:terms,id',
        ]);


        // Update the course group with the new data
        $courseGroup->update($request->all());

        return (request()->expectsJson()) ? response()->json([
            'data' => $courseGroup,
            'message' => 'Course group updated successfully.'
        ], 200) : back()->with('updated', 'Course group updated successfully.');
    }

    /**
     * Remove a course group from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $group = CourseGroup::findOrFail($id);

        // Check if the group has students
        if ($group->students()->exists()) {
            return (request()->expectsJson()) ? response()->json([
                'message' => 'Group cannot be deleted because it has associated students.',
            ], 400) : back()->with('failed', 'Group cannot be deleted because it has associated students.');
        }

        // Proceed to delete the group
        $group->delete();

        return (request()->expectsJson()) ? response()->json([
            'message' => 'Group deleted successfully.',
        ], 200) : back()->with('deleted', 'Course Group deleted');
    }

}
