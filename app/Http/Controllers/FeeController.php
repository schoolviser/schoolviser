<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Fee;

class FeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','usertype:master|employee']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fees =  Fee::current()->with(['clazz','category'])->get();

        $fees_structure = $fees->groupBy(function($fee){
            return $fee->clazz->abbr;
        })->map(function($item, $key){
            return $item->groupBy('residence')->map(function($i,$k){
                return $i->groupBy('gender')->map(function($ii, $kk){
                    return $ii->sum('amount');
                });
            });
        });

        return view('fees.index', compact('fees'));
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
