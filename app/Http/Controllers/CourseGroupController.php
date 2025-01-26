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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_code' => 'nullable|string|max:10|unique:course_groups',
            'description' => 'nullable|string',
            'graduated' => 'required|in:1,0',
            'completes_on' => 'nullable|date',
            'active' => 'required|in:1,0',
            'course_id' => 'nullable|exists:courses,id',
            'term_id' => 'nullable|exists:terms,id',
        ]);

        $courseGroup = CourseGroup::create($request->all());

        return response()->json([
            'data' => $courseGroup,
            'message' => 'Course group created successfully.'
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_code' => "nullable|string|max:10|unique:course_groups,short_code,$id",
            'description' => 'nullable|string',
            'graduated' => 'required|in:1,0',
            'completes_on' => 'nullable|date',
            'active' => 'required|in:1,0',
            'course_id' => 'nullable|exists:courses,id',
            'term_id' => 'nullable|exists:terms,id',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed.'
            ], 422);
        }

        // Update the course group with the new data
        $courseGroup->update($request->all());

        return response()->json([
            'data' => $courseGroup,
            'message' => 'Course group updated successfully.'
        ], 200);
    }

    /**
     * Remove a course group from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the course group by ID
        $courseGroup = CourseGroup::find($id);

        if (!$courseGroup) {
            return response()->json([
                'message' => 'Course group not found.'
            ], 404);
        }

        // Delete the course group
        $courseGroup->delete();

        return response()->json([
            'message' => 'Course group deleted successfully.'
        ], 200);
    }
}
