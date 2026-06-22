<?php

namespace App\Http\Controllers\Library;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Library\Item;
use App\Models\Library\ItemType;
use App\Models\Library\ItemCopy;
use App\Models\Library\Author;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::withCount('copies')->with(['itemType'])->paginate(50);

        return (request()->expectsJson()) ? response()->json([
            'items' => $items
        ]) : view('dashboard.library.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemTypes = ItemType::get();
        $authors = Author::get();

        return view('dashboard.library.items.create', compact('itemTypes', 'authors'));
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
            'issn' => 'nullable|unique:items,issn',
            'isbn' => 'nullable|unique:items,isbn'
        ]);

        $item = new Item;

        $item->title = $request->title;
        $item->isbn = $request->isbn;
        $item->issn = $request->issn;
        $item->ean = $request->ean;
        $item->edition = $request->edition;
        $item->item_type_id = $request->item_type;

        $item->save;

        if ($request->has('copies') && $request->copies > 0) {
            for ($i=0; $i < $request->copies; $i++) { 
                # code...
                ItemCopy::create([
                    'copy_number' => $i,
                    'item_id' => $item->id
                ]);

            }
        }

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Item created successfully ....!'
        ]) : back()->withInput()->with('created', 'Item created successfully ......!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);
        $copies = ItemCopy::whereItemId($id)->paginate(50);

        return (request()->expectsJson()) ? response()->json([
            'item' => $item,
            'copies' => $copies
        ]) : view('dashboard.library.items.show', compact('items', 'copies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return (request()->expectsJson()) ? response()->json([
            'item' => $item
        ]) : view('dashboard.library.items.edit', compact('item'));
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
        Item::whereId($id)->update([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'issn' => $request->issn,
            'ean' => $request->ean,
            'edition' => $request->edition,
            'item_type_id' => $request->item_type
        ]);

        return (request()->expectsJson()) ? reponse()->json([
            'success' => true,
            'message' => 'Item updated successfully ....!'
        ]) : back()->withInput()->with('updated', 'Item updated successfully ....!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::destroy($id);

        return (request()->expectsJson()) ? reponse()->json([
            'success' => true,
            'message' => 'Item deleted successfully ....!'
        ]) : back()->withInput()->with('updated', 'Item deleted successfully ....!');
    }
}
