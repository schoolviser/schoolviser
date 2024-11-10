<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;

class GenerateRegnoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        if(request('id')){
            $student = Student::whereId(request('id'))->firstOrFail();
            $student->generateRegNo();
        }else{
            $students = $this->getStudentsWithNoRegnos();
            foreach ($students as $student) {
                # code...
                $student->generateRegNo();
            }
        }
        
        return (request()->expectsJson()) ? response()->json([
            'success' => true , 'message' => 'Student registration numbers generated successfully'
        ], 200) : back()->with('created','Student registration numbers generated successfully');
    }

    /**
     * Get all the students who do not have reg nos
     */
    private function getStudentsWithNoRegnos()
    {
        return Student::whereNull('regno')->get();
    }
}
