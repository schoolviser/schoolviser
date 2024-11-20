<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\SubjectRepository;
use App\Entities\Subject;

class SubjectController extends Controller
{

    public function index()
    {
        $page = request()->input("page", 1);
        $subjects =  app(SubjectRepository::class)->fromCache()->paginate();
        return (request()->expectsJson()) ? response()->json($subject) : view('admin.subjects.index', compact('subjects'));
    }

    public function show($id)
    {
        return subject::findOrFail($id);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subjects,name|min:3,max:30',
            'level' => 'required',
        ]);

        $subject = new Subject;

        $subject->name = $request->name;
        $subject->level = $request->level;
        $subject->short_code = $request->short_code;
        $subject->short_name = $request->short_name;

        $subject->save();

        return back()->withInput()->with('created', 'Subject created successfully ...');


    }

    public function edit($id)
    {
        $subject = subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified subject in the database.
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id . ',id,level,' . $request->level,
            'short_name' => 'nullable|string|max:255|unique:subjects,short_name,' . $subject->id,
            'short_code' => 'nullable|string|max:255|unique:subjects,short_code,' . $subject->id,
            'level' => 'required|in:o,a',
            //'compulsory' => 'required|in:1,0',
            //'meta' => 'nullable|string',
        ]);

        // Update the subject
        $subject->name = $request->name;
        $subject->level = $request->level;
        $subject->short_code = $request->short_code;
        $subject->short_name = $request->short_name;

        $subject->save();

        return back()->withInput()->with('updated', 'Subject updated successfully.');
    }
    
}
