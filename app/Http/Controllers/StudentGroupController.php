<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;
use App\Group;


use App\Option;


class StudentGroupController extends Controller
{

    /**
     * Show students of the current year and term - order by date registered
     */
    public function index()
    {
        $groups = Group::of(Student::class)->withCount(['students'])->get();
        return view('students.groups.index', compact('groups'));
    }

    /**
     * Show page for adding student
     */
    public function create()
    {
        
    }

    /**
     * Create student group
     */
    public function store()
    {
        
    }

    /**
     * Show the group and listing of students that belong to that group
     */
    public function students($id)
    {
        $group = Group::findOrFail($id);
        $students = $group->students()->get();
        return view('students.groups.students', compact('students', 'group'));
    }


    /**
     * Remove student from the relationship
     */
    public function remove($id)
    {
        
    }

    public function add()
    {
        
    }

}
