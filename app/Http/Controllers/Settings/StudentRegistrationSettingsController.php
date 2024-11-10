<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\OptionRepository;


class StudentRegistrationSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','usertype:master|employee']);
    }

    public function index()
    {
        return view('settings.students.registration.index');
    }

    public function update(Request $request)
    {
        ($request->has('auto_generate_student_regno')) ? app(OptionRepository::class)->remember('auto_generate_student_regno')->updateOrCreate(['key' => 'auto_generate_student_regno'], ['key' => 'auto_generate_student_regno','value' => $request->auto_generate_student_regno, 'identifier' => 'student registration']) : app(OptionRepository::class)->remember('auto_generate_student_regno')->updateOrCreate(['key' => 'auto_generate_student_regno'], ['key' => 'auto_generate_student_regno','value' => '0', 'identifier' => 'student registration']);
        ($request->has('allow_selection_of_term_to_register_student')) ? app(OptionRepository::class)->remember('allow_selection_of_term_to_register_student')->updateOrCreate(['key' => 'allow_selection_of_term_to_register_student'], ['key' => 'allow_selection_of_term_to_register_student','value' => $request->allow_selection_of_term_to_register_student, 'identifier' => 'student registration']) : app(OptionRepository::class)->remember('allow_selection_of_term_to_register_student')->updateOrCreate(['key' => 'allow_selection_of_term_to_register_student'], ['key' => 'allow_selection_of_term_to_register_student','value' => '0', 'identifier' => 'student registration']);
        return back()->withInput();

    }


}
