<?php

namespace Modules\Schoolviser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Schoolviser\Entities\Cohort;

use Modules\Schoolviser\Repositories\IntakeRegistrationRepository;
use Modules\Schoolviser\Repositories\AcademicYearRepository;
use Modules\Schoolviser\Repositories\CourseRepository;
use Modules\Schoolviser\Repositories\StudentRepository;

class CohortController extends Controller
{
    public function index()
    {
        $cohorts = Cohort::with(['course','academicYear'])->paginate(20);
        return view('schoolviser::cohorts.index', compact('cohorts'));
    }

    public function create()
    {
        $courses = app(CourseRepository::class)->company(company()->id)->getAllCourses();
        $academicYears = app(AcademicYearRepository::class)->company(company()->id)->getAllYears();

        return view('schoolviser::cohorts.create', compact(
            'courses',
            'academicYears'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'short_code'       => 'nullable|string|max:10',
            'description'      => 'nullable|string',
            'course_id'        => 'nullable|exists:courses,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'starts_on'        => 'nullable|date',
            'ends_on'          => 'nullable|date',
        ]);

        $cohort = new Cohort;

        // Assign validated data using mass assignment
        $cohort->fill($data);

        // Explicitly set company_id
        $cohort->company_id = company()->id;

        $cohort->save();

        return redirect()->route('managecourses.cohorts.index')
            ->with('success', 'Cohort created successfully.');
    }

    public function show(string $id)
    {
        $cohort = Cohort::with(['students','course','academicYear'])->findOrFail($id);
        
        return view('schoolviser::cohorts.show', compact('cohort'));
    }

    public function edit(string $id)
    {
        $cohort = Cohort::findOrFail($id);
        return view('schoolviser::cohorts.edit', compact('cohort'));
    }

    public function update(Request $request, string $id)
    {
        $cohort = Cohort::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'short_code'  => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'active'      => 'boolean',
            'starts_on'   => 'nullable|date',
            'ends_on'     => 'nullable|date',
        ]);

        $cohort->update($data);

        return redirect()->route('managecourses.cohorts.index')
            ->with('success', 'Cohort updated successfully.');
    }

    public function destroy(string $id)
    {
        $cohort = Cohort::findOrFail($id);

        if ($cohort->students()->exists()) {
            return back()->withErrors([
                'error' => 'Cannot delete cohort because students are assigned.'
            ]);
        }

        $cohort->delete();

        return redirect()->route('managecourses.cohorts.index')
            ->with('success', 'Cohort deleted successfully.');
    }
}