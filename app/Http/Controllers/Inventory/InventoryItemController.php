<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\InventoryItem;


class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventoryItems = InventoryItem::with(['unitOfMeasure'])->paginate(50);

        return view('dashboard.inventory.items.index', compact('inventoryItems'));
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
            'unit_of_measure' => 'required',
            'code' => 'nullable',
            'name' => 'required|unique:inventory_items,name'
        ]);

        $inventoryItem = new InventoryItem;
        $inventoryItem->name = $request->name;
        $inventoryItem->code = $request->code;
        $inventoryItem->stock_alert = $request->stock_alert;
        $inventoryItem->consumable = $request->consumable ?? 1;
        $inventoryItem->unit_of_measure_id = $request->unit_of_measure;

        $inventoryItem->save();

        return back()->withInput()->with('created', 'Inventory item added successfully ....!');
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
        InventoryItem::destroy($id);
        return back()->with('deleted', 'Items deleted successfully ...!');
    }
}
