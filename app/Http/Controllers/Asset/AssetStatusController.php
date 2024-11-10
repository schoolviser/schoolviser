<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Asset\AssetStatus;

class AssetStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses =  config('defaults.asset_status');
        for ($i=0; $i < count($statuses); $i++) { 
            AssetStatus::updateOrCreate([
                'name' => $statuses[$i]['name'],
                'description' => $statuses[$i]['description'],
            ]);
        }
        $assetStatuses =  AssetStatus::orderBy('created_at', 'desc')->get();

        return view('dashboard.assets.status.index', compact('assetStatuses'));
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
        $request->validate([
            'name' => 'required|unique:asset_statuses,name',
            'description' => 'nullable'
        ]);

        $status = New AssetStatus;

        $status->name = $request->name;
        $status->description = $request->description;
        $status->flag = $request->flag;
        $status->check_out = $request->check_out ?? '0';

        $status->save();
        return back()->withInput()->with('created', 'Asset status created successfully');

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
        AssetStatus::destroy($id);
        return back()->with('deleted', 'Asset status deleted successjfully ....');
    }
}
