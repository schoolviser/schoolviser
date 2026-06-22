<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room;

class RoomController extends Controller
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
    public function store(Request $request)
    {
        $room = new Room;
        $room->name = $request->room_name;
        $room->building_id = $request->building;

        $room->save();

        return back()->withInput()->with('created', 'Room created successfully .....');
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
        Room::whereId($id)->update([
            'name' => $request->name,
            'room_type' => $request->room_type
        ]);

        return (request()->expectsJson()) ? response()->json(['success' => true, 'message' => 'Room info updated successfully']) : back()->withInput()->with('updated', 'Room info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Room::destroy($id);
        return (request()->expectsJson()) ? response()->json(['success' => true, 'message' => 'Room deleted successfully']) : back()->with('deleted', 'Room deleted successfully');
    }
}
