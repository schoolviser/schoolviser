<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Asset\FixedAssetAccount;
use App\Models\Coa;

class FixedAssetAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fixedAssetAccounts =  FixedAssetAccount::with(['account'])->get();

        $ids = collect($fixedAssetAccounts)->map(function($item){
            return $item->account_id;
        });


        $coas =  Coa::asset()->get()->map(function($item){
            return $item;
        })->reject(function($item) use($ids){
            return in_array($item->id, $ids->toArray());
        });

        return view('dashboard.assets.accounts.index', compact('coas','fixedAssetAccounts'));

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
        $account = new FixedAssetAccount;
        $account->account_id = $request->account_id;

        $account->save();

        return back()->withInput()->with('created', 'Account has been marked as for fixed assets');
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
        FixedAssetAccount::destroy($id);
        return back()->with('deleted', 'Fixed asset account deleted successfully ....');
    }
}
