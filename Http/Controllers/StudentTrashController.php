<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Clazz;
use App\Models\TermlyRegistration;
use App\Group;

use App\Http\Requests\RegisterStudentRequest;


use App\Option;


class StudentTrashController extends Controller
{

     /**
     * Display a listing of deleted students
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $students = Student::onlyTrashed()->with(['currentTermlyRegistration'=> function($q){
            $q->withTrashed();
        }])->get();
        return (request()->expectsJson()) ? response()->json($students) :  view('dashboard.students.trash.index', compact('students'));
    }

     /**
     * Restore deleted student
     */
    public function restore($id)
    {
        $student = Student::withTrashed()->find($id);
        $student->restore();

        return (request()->expectsJson()) ? response()->json(['success' => true, 'message' => 'Student restored successfully']) : back();

    }

    public function destroyPermanently($id)
    {
        Student::onlyTrashed()->findOrFail($id)->forceDelete();
        return (request()->route()->named('students.profile')) ? redirect('students') : back();
    }

    
     /**
     * Display a listing of deleted students
     *
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        $trash = Student::onlyTrashed()->get();
        $count = $trash->count();

        return response()->json([
            'count' => $count,
            'description' => 'The number of deleted students'
        ]);
    }

    
     /**
     * Display a listing of deleted students
     *
     * @return \Illuminate\Http\Response
     */
    public function empty()
    {
    }
}
