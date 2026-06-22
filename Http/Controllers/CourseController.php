<?php

namespace Modules\Schoolviser\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Modules\Schoolviser\Http\Requests\StoreCourseRequest;
use Modules\Schoolviser\Http\Requests\UpdateCourseRequest;

use Modules\Schoolviser\Entities\Course;
use Modules\Schoolviser\Entities\Department;

use Modules\Schoolviser\Services\CourseService;
use Modules\Schoolviser\Repositories\CourseRepository;


class CourseController extends Controller
{

    public function __construct(
        protected CourseRepository $courseRepository, 
        protected CourseService $courseService)
    {
        $this->middleware(function ($request, $next) {
            $company = company();

            if (! in_array($company->school_type, ['tertiary'])) {
                abort(403, 'Access denied. Only tertiary schools can manage courses.');
            }

            return $next($request);
        });

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = company()?->id;

        $page = request()->input('page') ?? 1;

        $courses = $this->courseRepository->fromCache()->company($companyId)->getPaginatedCouses(10, $page);
        $departments = Department::all();

        log_activity([
            'action'    => 'viewed.courses.listing',
            'company_id' => company()?->id,
            'message'   => auth()->user()->name." viewed courses information ",
            'visibility' => 'company_admin',
        ]);

        return (request()->expectsJson()) ? response()->json([
            'data' => $courses
        ]) : view('schoolviser::courses.index', compact('courses', 'departments'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $request->validated();

        $companyId = company()?->id;

        $course = $this->courseService->company($companyId)->createCourse($request);

         log_activity([
            'action'     => 'create.course',
            'company_id' => $companyId,
            'new'        => $course,
            'subject'    => $course,
            'message'    => auth()->user()->name . " created new course with Reference ".$course->uuid,
            'visibility' => 'company_admin',
        ]);


        

        return back()->withInput()->with('success', 'Course created successfully');

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        $request->validated();

        $companyId = company()?->id;

        // Find the course or throw a 404 error
        $oldCourse = $this->courseRepository->company($companyId)->getCourse($id);

        $updatedCourse = $this->courseService->company($companyId)->updateCourse($oldCourse, $request);

         log_activity([
            'action'     => 'updated.course',
            'company_id' => $companyId,
            'old'        => $oldCourse,
            'new'        => $updatedCourse,
            'subject'    => $updatedCourse,
            'message'    => auth()->user()->name . " updated course with Reference ".$updatedCourse->uuid,
            'visibility' => 'company_admin',
        ]);

        return back()->with('success', 'Course details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companyId = company()?->id;

        // Find the course or throw a 404 error
        $course = $this->courseRepository->company($companyId)->getCourse($id);

        $deleted = $this->courseService->company($companyId)->deleteCourse($course);

        if (!$deleted) {
            // Course has students, cannot delete
            return back()->withErrors([
                'error' => 'This course cannot be deleted because students are enrolled.'
            ]);
        }

        log_activity([
            'action'     => 'deleted.course',
            'company_id' => $companyId,
            'old'        => $course,
            'new'        => $course,
            'subject'    => $course,
            'message'    => auth()->user()->name . " deleted course with Reference ".$course->uuid,
            'visibility' => 'company_admin',
        ]);

        return back()->with('success', 'Course deleted successfully!');
    }
}
