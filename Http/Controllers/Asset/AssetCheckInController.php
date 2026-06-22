<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Asset\AssetCheckOut;
use App\Models\Asset\AssetCheckIn;
use App\Models\Asset\Asset;


//Events
use App\Events\AssetCheckIn as AssetCheckInEvent;

class AssetCheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function checkin(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $checkout = AssetCheckOut::findOrFail($id);
        $asset = Asset::findOrFail($checkout->asset_id);

        $checkin = new AssetCheckIn;

        $checkin->date = $request->date;
        $checkin->checkout_id = $id;
        $checkin->checked_in_by = auth()->user()->id;

        $checkin->save();

        event(new AssetCheckInEvent($asset));

        return back()->withInput()->with('created', 'Asset successfully checked in');
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
