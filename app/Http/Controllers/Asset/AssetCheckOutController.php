<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Asset\AssetCheckOut;
use App\Models\Asset\Asset;

//Events
use App\Events\AssetCheckedOut;


class AssetCheckOutController extends Controller
{
    /**
     * Store checkout details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request, $id)
    {
        $request->validate([
            'check_out_date' => 'required|date',
            'due_date' => 'required|date',
            'employee' => 'required',
            'note' => 'nullable',
        ]);

        $asset = Asset::findOrFail($id);

        $checkout = new AssetCheckOut;

        $checkout->date = $request->check_out_date;
        $checkout->due_date = $request->due_date;
        $checkout->employee_id = $request->employee;
        $checkout->note = $request->note;
        $checkout->asset_id = $id;

        $checkout->save();

        event(new AssetCheckedOut($asset));

        return back()->withInput()->with('created', 'Asset successfully checked out');
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
