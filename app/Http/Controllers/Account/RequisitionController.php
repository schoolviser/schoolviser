<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Requisition\Requisition;
use App\Models\Department\Department;

use App\Support\Models\Any;

class RequisitionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','usertype:employee|master']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dbrequisitions = Requisition::where('requested_by', auth()->user()->user_id)->get();

        $requisitions =  collect($dbrequisitions)->map(function($requisition, $key){
            return new Any([
                'id' => $requisition->id,
                'description' => $requisition->description,
                'requester' => $requisition->requester,
                'date' => $requisition->date,
                'items' => collect($requisition->items)->map(function($item, $key){
                    return new Any([
                        'id' => $item->id,
                        'name' => $item->name,
                        'rate' => $item->rate,
                        'quantity' => $item->quantity,
                        'amount' => ($item->rate * $item->quantity)
                    ]);
                })
            ]);
            
        });

        return view('dashboard.account.requisitions.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments =  Department::all();
        
        return view('dashboard.account.requisitions.create', compact('departments'));
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
            'description' => 'required',
            'date' => 'required|date',
            'department' => 'required'
        ]);

        $requisition = new Requisition;
        $requisition->description = $request->description;
        $requisition->date = $request->date;
        $requisition->department_id = $request->department;
        $requisition->requested_by = auth()->user()->user_id;

        $requisition->save();

        if ($request->has('items') && count($request->items) > 0) {
            foreach($request->items as $item){
             if ($item['name'] && $item['quantity'] && $item['rate']) {
                 # code...
                 $requisition->items()->create([
                     'name' => $item['name'],
                     'quantity' => $item['quantity'],
                     'rate' => $item['rate'],
                     'unit_of_measure_id' => $item['unit_of_measure'] ?? null,
                 ]);
             }
            }
         }

        return back()->withInput();
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
