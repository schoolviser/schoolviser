<?php

namespace Modules\Schoolviser\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Schoolviser\Entities\CourseGroup;
use Illuminate\Support\Facades\Validator;

use Modules\Schoolviser\Repositories\CourseGroupRepository;

# Services
use Modules\Schoolviser\Services\CourseGroupService;

# Requests
use Modules\Schoolviser\Http\Requests\StoreCourseGroupRequest;
use Modules\Schoolviser\Http\Requests\UpdateCourseGroupRequest;

class CourseGroupController extends Controller
{
    public function __construct(
        protected CourseGroupRepository $courseGroupRepository,
        protected CourseGroupService $courseGroupService
    )
    {
        
    }
    /**
     * Display a paginated list of course groups.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = request()->get('page', 1);

        $company = company();

        $courseGroups = $this->courseGroupRepository->company($company->id)->getPaginatedCourseGroups(15, $page);

        $courses = \Modules\Schoolviser\Entities\Course::all();
        $terms = \Modules\Schoolviser\Entities\Term::all();

        return (request()->expectsJson()) ?  response()->json([
            'data' => $courseGroups,
            'message' => 'Course groups retrieved successfully.'
        ], 200) : view('schoolviser::courses.coursegroups.index', compact('courseGroups', 'courses','terms'));
    }

    /**
     * Store a new course group in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCourseGroupRequest $request)
    {
        $company = company();

        // Create the course group
        $courseGroup = $this->courseGroupService->company($company->id)->create($request->validated());

        // Return the course group with its course details
        return $request->expectsJson() ? response()->json([
            'data' => $courseGroup,
            'message' => 'Course group created successfully.',
        ], 201) : back()->with('success', 'Course group created successfully.');
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
    public function update(UpdateCourseGroupRequest $request, $uuid)
    {
        $company = company();

        $courseGroup = CourseGroup::whereCompanyId($company->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Pass the actual ID into the request so rules can use it
        $request->merge(['course_group_id' => $courseGroup->id]);

        $courseGroup = $this->courseGroupService
            ->company($company->id)
            ->update($courseGroup, $request->validated());

        return request()->expectsJson()
            ? response()->json([
                'data'    => $courseGroup,
                'message' => 'Course group updated successfully.'
            ], 200)
            : back()->with('updated', 'Course group updated successfully.');
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
