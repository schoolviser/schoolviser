<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Vendor\Vendor;
use App\Models\Vendor\VendorContactPerson;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::paginate(50);
        return (request()->expectsJson()) ? response()->json($vendors) : view('admin.vendors.index', compact('vendors'));
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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::with(['bills' => function($billsQuery){
            $billsQuery->unCleared();
        }])->findOrFail($id);

        return response()->json([$vendor]);
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
        Vendor::destroy($id);

        return (request()->expectsJson()) ? response()->json([
            'message' => 'Vendor deleted successfully'
        ], 200) : back()->with('message', 'Vendor deleted successfully');
    }


    //Gett all vendors excluding relations
    public function vendorsWithoutRelations()
    {
        $vendors = Vendor::all();
        return (request()->expectsJson()) ? response()->json($vendors) : view('admin.vendors.index', compact('vendors'));
    }

}
