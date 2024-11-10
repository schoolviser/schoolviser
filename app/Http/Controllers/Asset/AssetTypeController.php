<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Asset\AssetType;
use App\Models\Asset\Asset;
use App\Models\Coa;
use App\Models\Asset\FixedAssetAccount;

use App\Support\Models\Any;


class AssetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assetTypes = AssetType::with(['categories'])->withCount('assets')->orderBy('created_at', 'desc')->paginate();
        return (request()->expectsJson()) ? response()->json($assetTypes) : view('dashboard.assets.types.index', compact('assetTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assetAccounts =  FixedAssetAccount::with('account')->get()->map(function($item){
            return new Any([
                'id' => $item->account->id,
                'name' => $item->account->name,
                'code' => $item->account->code,
                'subtype' => 'Fixed Asset',
            ]);
        });
        $expenseAccounts =  Coa::expense()->get();
        return view('dashboard.assets.types.create', compact('assetAccounts', 'expenseAccounts'));
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
            'name' => 'required|unique:asset_types,name',
            'description' => 'nullable'
        ]);

        $type = new AssetType;
        $type->name = $request->name;
        $type->description = $request->description;
        $type->asset_account_id = $request->asset_account;
        $type->expense_account_id = $request->expense_account;
        $type->depreciation_account_id = $request->depreciation_account;
        $type->depreciation_method = $request->depreciation_method;
        $type->useful_life = $request->useful_life;

        $type->save();
        
        return back()->withInput()->with('created', 'Asset type created successfully');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function items($id)
    {
        $assettype = AssetType::whereId($id)->first();

        $items =  Asset::whereAssetTypeId($id)->with(['type','custodian','location' => function($locationQuery){
            $locationQuery->with('building');
        },'transaction' => function($transactionsQuery){
            $transactionsQuery->with(['employee:id,photo,first_name,last_name']);
        }])->orderBy('created_at', 'desc')->get();

        $asset_type = new Any([
            'id' => $assettype->id,
            'name' => $assettype->name,
            'items' => $items
        ]);
        return (request()->expectsJson()) ? response()->json($asset_type) : view('dashboard.assets.types.items', compact('asset_type'));

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
        AssetType::destroy($id);
        return back()->with('deleted', 'Asset type deleted successfully ...');
    }
}
