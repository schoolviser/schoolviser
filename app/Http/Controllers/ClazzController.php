<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Entities\Clazz;

use App\Repositories\ClazzRespository;


class ClazzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clazzs = app(ClazzRespository::class)->fromCache()->getClazzes();

        return view('admin.clazzs.index', compact('clazzs'));
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
            'name' => 'required|unique:clazzs,name',
            'abbr' => 'required|unique:clazzs,abbr'
        ]);

        $clazz = new Clazz;

        $clazz->name = $request->name;
        $clazz->abbr = $request->abbr;
        $clazz->level = $request->level ?? 'ordinary';

        $clazz->save();
        
        return back()->withInput()->with('created', 'Class has been created successfully ....');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clazz = Clazz::whereId($id)->firstOrFail();
        return view('admin.clazzs.edit', compact('clazz'));
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
        $clazz = Clazz::whereId($id)->update([
            'name' => $request->name,
            'abbr' => $request->abbr,
            'level' => $request->level
        ]);

        return back()->withInput()->with('updated', 'Clazz info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clazz::destroy($id);
        return back()->with('deleted', 'Class deleted successfully');
    }
}
