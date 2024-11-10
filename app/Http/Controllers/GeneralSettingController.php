<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Repository\OptionRepository;

class GeneralSettingController extends Controller
{ 

    public function index()
    {
        return (request()->expectsJson()) ? response()->json($options) : view('dashboard.settings.general.index');
    }

    /**
     * Update or create general settings
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required|min:3|max:100',
            'current_year' => 'required|numeric',
            'current_term_start_date' => 'required|date',
            'current_term_end_date' => 'date',
            'next_term_start_date' => 'date'
        ]);

        

        ($request->has('school_name')) ? app(OptionRepository::class)->remember('school_name')->updateOrCreate(['key' => 'school_name'], ['key' => 'school_name','value' => $request->school_name, 'identifier' => 'general_settings']) : '';
        ($request->has('current_year')) ? app(OptionRepository::class)->remember('current_year')->updateOrCreate(['key' => 'current_year'], ['key' => 'current_year','value' => $request->current_year, 'identifier' => 'general_settings']) : '';
        ($request->has('current_term')) ? app(OptionRepository::class)->remember('current_term')->updateOrCreate(['key' => 'current_term'], ['key' => 'current_term','value' => $request->current_term, 'identifier' => 'general_settings']) : '';
        ($request->has('current_term_start_date')) ? app(OptionRepository::class)->remember('current_term_start_date')->updateOrCreate(['key' => 'current_term_start_date'], ['key' => 'current_term_start_date','value' => $request->current_term_start_date, 'identifier' => 'general_settings']) : '';
        ($request->has('current_term_end_date')) ? app(OptionRepository::class)->remember('current_term_end_date')->updateOrCreate(['key' => 'current_term_end_date'], ['key' => 'current_term_end_date','value' => $request->current_term_end_date, 'identifier' => 'general_settings']) : '';
        ($request->has('look_back_years')) ? app(OptionRepository::class)->remember('look_back_years')->updateOrCreate(['key' => 'look_back_years'], ['key' => 'look_back_years','value' => $request->look_back_years, 'identifier' => 'general_settings']) : '';
        ($request->has('next_term_start_date')) ? app(OptionRepository::class)->remember('next_term_start_date')->updateOrCreate(['key' => 'next_term_start_date'], ['key' => 'next_term_start_date','value' => $request->next_term_start_date, 'identifier' => 'general_settings']) : '';

        return (request()->expectsJson()) ? response()->json(['success' => true, ['message' => 'General settings updated successfully']]) : back()->withInput();
    }
    
}
