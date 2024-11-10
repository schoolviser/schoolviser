<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requirement\Requirement;
use App\Models\Requirement\RequirementItem;
use App\Models\Clazz;

use App\Models\TermlyRegistration;

use App\Support\Models\Any;



class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year, $term)
    {

        return $clazz = Clazz::with(['requirements' => function($requirementsQuery) use($year, $term){
            $requirementsQuery->with(['unitOfMeasure','item'])->whereHas('term', function($termQuery) use($year, $term){
                $termQuery->whereTerm($term)->where('year', $year);
            });
        }])->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
