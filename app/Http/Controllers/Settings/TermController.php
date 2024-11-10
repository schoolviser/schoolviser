<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Term;
use Illuminate\Support\Facades\Cache;


class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $terms = Term::current()->get();
        
        if (count($terms) > 1) {
            foreach ($terms as $term) {
                # code...
                $term->update(['is_current' => '0']);
            }
        }
        return view('dashboard.settings.general.term');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $terms = Term::current()->get();

        if (count($terms) > 1) {
            foreach ($terms as $term) {
                # code...
                $term->update(['is_current' => '0']);
            }
        }
        $term = Term::updateOrCreate(['year' => $request->year, 'term' => $request->term], [
            'year' => $request->year,
            'term' => $request->term,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => '1'
        ]);

        Cache::put('current:term', $term->toArray(), now()->addMinutes(100));

        return back()->withInput();
    }

}
