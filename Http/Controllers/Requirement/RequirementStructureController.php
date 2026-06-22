<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Clazz;

use App\Support\Models\Any;

class RequirementStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year, $term)
    {
        $clazzs = Clazz::with(['requirements' => function($requirementsQuery) use($year, $term){
            $requirementsQuery->with(['item'])->whereHas('term', function($termQuery) use($year, $term){
                $termQuery->where('year', $year)->whereTerm($term);
            });
        }])->get();

        $requirementsBreakDowns = collect($clazzs)->map(function($item, $key){
            return new Any([
                'clazz' => new Any([
                    'id' => $item->id,
                    'name' => $item->name,
                    'abbr' => $item->abbr,
                    'level' => $item->level
                ]),
                'requirements' => new Any([
                    'dayMaleNew' => $item->requirements->where('residence', 'day')->where('gender', 'male')->where('new_or_continuing', 'new'),
                    'dayFemaleNew' => $item->requirements->where('residence', 'day')->where('gender', 'female')->where('new_or_continuing', 'new'),
                    'dayMaleContinuing' => $item->requirements->where('residence', 'day')->where('gender', 'male')->where('new_or_continuing', 'continuing'),
                    'dayFemaleContinuing' => $item->requirements->where('residence', 'day')->where('gender', 'female')->where('new_or_continuing', 'continuing'),

                    'boardingMaleNew' => $item->requirements->where('residence', 'boarding')->where('gender', 'male')->where('new_or_continuing', 'new'),
                    'boardingFemaleNew' => $item->requirements->where('residence', 'boarding')->where('gender', 'female')->where('new_or_continuing', 'new'),
                    'boardingMaleContinuing' => $item->requirements->where('residence', 'boarding')->where('gender', 'male')->where('new_or_continuing', 'continuing'),
                    'boardingFemaleContinuing' => $item->requirements->where('residence', 'boarding')->where('gender', 'female')->where('new_or_continuing', 'continuing'),
                ])
                
            ]);
        });
        return view('dashboard.requirements.structure.index', compact('requirementsBreakDowns'));
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
