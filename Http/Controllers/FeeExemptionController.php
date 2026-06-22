<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FeeExemption;
use App\TermlyRegistration;


class FeeExemptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year = null, $term = null, $class_id = null)
    {
        $year = $year ?? option('current_year');
        $term = $term ?? option('current_term');

        $fee_exemptions = TermlyRegistration::current('id,surname,other_names,gender')->whereHas('feeExceptions')->with(['feeExceptions'])->get();

        $sum_map = collect($fee_exemptions)->map(function($item, $key){
            return $item->feeExceptions->sum('pivot.discount');
        });

        $fee_exemptions_sum =  array_sum($sum_map->toArray());

        return (request()->expectsJson()) ? response()->json([
            'fees_exemptions' => $fee_exemptions,
            'fee_exemptions_sum' => $fee_exemptions_sum
        ]) : view('fees.exemptions.index', compact(['fee_exemptions', 'fee_exemptions_sum']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $fee_exemptions = FeeExemption::ofTerm($term ?? option('current_term'))->ofYear($year)->with(['termlyRegistration' => function($termlyRegistrationQuery) use($year, $term){
            return $termlyRegistrationQuery->where([
                'term' => $term,
                'year' => $year
            ])->with('student:id,surname,other_names');
        }])->ofClass($class_id, $year, $term)->get();

        $fee_exemptions_sum = $fee_exemptions->sum('amount');
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
        return $fee_exemption = FeeExemption::with(['termlyRegistration' => function($termlyRegistrationQuery){
            $termlyRegistrationQuery->with('student:id,surname,other_names,photo');
        }])->findOrFail($id);
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
        FeeExemption::whereId($id)->update([
            'amount' => $request->amount,
            'reason' => $request->reason
        ]);

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FeeExemption::destroy($id);

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Fee exemption deleted successfully'
        ]) : back();
    }
}
