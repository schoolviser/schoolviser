<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Student\Entities\YearGroup;
use App\Entities\AcademicYear;

use Illuminate\Validation\Rule;


class YearGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $yearGroups = YearGroup::withCount('students')->get();
        return view('student::settings.yeargroups.index', compact('yearGroups'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $academic_years = AcademicYear::all();

        return view('student::settings.yeargroups.create', compact('academic_years'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:year_groups,name',
            'year' => 'required'
        ]);

        $group = new YearGroup;

        $group->name = $request->name;
        $group->academic_year_id = $request->year;

        $group->save();

        ($request->has('description')) ? $group->setMeta('description', $request->description) : '';

        return back()->withInput()->with('created', 'Year group created successfully ....');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('student::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $group = YearGroup::whereId($id)->firstOrFail();
        $academic_years = AcademicYear::all();

        return view('student::settings.yeargroups.edit', compact('group', 'academic_years'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {   
        $group = YearGroup::whereId($id)->firstOrFail();

        $request->validate([
            'name' => [
                Rule::unique('year_groups')->ignore($group->id)
            ]
        ]);
        
        $group->name = $request->name;
        $group->academic_year_id = $request->year;

        $group->save();

        ($request->has('description')) ? $group->setMeta('description', $request->description) : '';

        return back()->withInput()->with('updated', 'Year group updated successfully .....!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        YearGroup::destroy($id);
        return back();
    }
}
