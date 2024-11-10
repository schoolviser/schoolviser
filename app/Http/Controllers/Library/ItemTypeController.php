<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Library\ItemType;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of item types.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemTypes = ItemType::get();

        return (request()->expectsJson()) ? response()->json([
            'itemTypes' => $itemTypes
        ]) : view('dashboard.library.itemtypes.index', compact('itemTypes'));
    }

    /**
     * Show the form for creating a new item type.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.library.itemtypes.create');
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
            'name' => 'required|unique:item_types,name',
            'description' => 'nullable'
        ]);

        $itemType = new ItemType;
        $itemType->name = $request->name;
        $itemType->description = $request->description;

        $itemType->save();

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Item created successfully ..!'
        ]) : back()->withInput()->with('created', 'Item type created successfully ....!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $itemType = ItemType::findOrFail($id);

        return (request()->expectsJson()) ? response()->json([
            'itemType' => $itemType
        ]) : view('dashboard.library.itemtypes.show', compact('itemType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemType = ItemType::findOrFail($id);
        return view('dashboard.library.itemtypes.edit', compact('itemType'));
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
        ItemType::whereId($id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return (request()->expectsJson()) ? reponse()->json([
            'success' => true,
            'message' => 'Item type updated successfully ....!'
        ]) : back()->withInput()->with('updated', 'Item type updated successfully ....!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ItemType::destroy($id);

        return (request()->expectsJson()) ? reponse()->json([
            'success' => true,
            'message' => 'Item type deleted successfully ....!'
        ]) : back()->withInput()->with('updated', 'Item type deleted successfully ....!');
    }
    
}
