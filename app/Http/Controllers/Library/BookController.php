<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Library\Item;
use App\Models\Library\ItemType;
use App\Models\Library\ItemCopy;
use App\Models\Library\Author;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Item::books()->withCount('copies')->with(['itemType'])->orderBy('created_at', 'desc')->paginate(50);

        return (request()->expectsJson()) ? response()->json([
            'books' => $books
        ]) : view('dashboard.library.items.books.index', compact('books'));
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
            'issn' => 'nullable|unique:items,issn',
            'isbn' => 'nullable|unique:items,isbn'
        ]);

        $itemType = ItemType::firstOrCreate(['name' => 'book']);

        $item = new Item;

        $item->title = $request->title;
        $item->isbn = $request->isbn;
        $item->issn = $request->issn;
        $item->ean = $request->ean;
        $item->edition = $request->edition;
        $item->item_type_id = $itemType->id;

        $item->save();

        if ($request->has('copies') && $request->copies > 0) {
            for ($i=0; $i < $request->copies; $i++) { 
                # code...
                ItemCopy::create([
                    'copy_number' => ($i + 1),
                    'item_id' => $item->id
                ]);

            }
        }

        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Book created successfully ....!'
        ]) : back()->withInput()->with('created', 'Book created successfully ......!');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book =  Item::books()->with(['copies'])->findOrFail($id);

        return view('dashboard.library.items.books.show', compact('book'));
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
