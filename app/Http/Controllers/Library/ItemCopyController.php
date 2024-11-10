<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Library\ItemCopy;
use App\Models\Library\Item;


class ItemCopyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($item_id)
    {
        $itemCopies = ItemCopy::whereItemId($item_id)->paginate(50);

        return (request()->expectsJson()) ? response()->json([
            'itemCopies' => $itemCopies
        ]) : view('dashboard.library.items.copies.index', compact('itemCopies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $item_id)
    {
        $request->validate([
            'barcode' => 'nullable|unique:item_copies,barcode'
        ]);

        $itemCopy = new ItemCopy;

        $itemCopy->copy_number = $request->copy_number;
        $itemCopy->barcode = $request->barcode;
        $itemCopy->item_id = $request->item;

        $itemCopy->save();

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Item Copy created successfully ....!',
            'itemCopy' => $itemCopy
        ]) : back()->withInput()->with('created', 'Item Copy created successfully ......!');
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
        $itemCopy = ItemCopy::with(['item'])->findOrFail($id);

        return (request()->expectsJson()) ? response()->json([
            'itemCopy' => $itemCopy,
        ]) : view('dashboard.library.items.copies.show', compact('itemCopy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemCopy = ItemCopy::with(['item'])->findOrFail($id);

        return view('dashboard.library.items.copies.edit', compact('itemCopy'));
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
        ItemCopy::whereId($id)->update([
            'copy_number' => $request->copy_number,
            'barcode' => $request->barcode,
            'item_id' => $request->item
        ]);

        return (request()->expectsJson()) ? reponse()->json([
            'success' => true,
            'message' => 'ItemCopy updated successfully ....!'
        ]) : back()->withInput()->with('updated', 'ItemCopy updated successfully ....!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ItemCopy::destroy($id);

        return (request()->expectsJson()) ? reponse()->json([
            'success' => true,
            'message' => 'ItemCopy deleted successfully ....!'
        ]) : back()->withInput()->with('updated', 'ItemCopy deleted successfully ....!');
    }
}
