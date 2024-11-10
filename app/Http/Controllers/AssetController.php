<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetStatus;
use App\Models\Accounting\Coa\FixedAsset;
use App\Models\Asset\AssetLocation;

use App\Models\Building;
use App\Models\Room;

use Carbon\Carbon;

use App\Support\Models\Any;


//Exports
use App\Exports\AssetExport;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function __construct()
    {
    }

    public function overview()
    {

        $assets = Asset::get();
        $checkouts = Asset::checkedOut()->get()->count();

        $overdue = Asset::checkedOut()->whereHas('transaction', function($transactionQuery){
            $transactionQuery->where('due_date', '<', Carbon::now());
        })->get()->count();

     

        $dashboard = new Any([
            'assets' => $assets->count(),
            'checked_out' => $checkouts,
            'overdue' => $overdue,
            'total_cost' => $assets->sum('purchase_cost')
        ]);

        return (request()->expectsJson()) ? response()->json($dashboard) : view('dashboard.assets.overview', compact('dashboard'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets =  Asset::with(['type','custodian','location' => function($locationQuery){
            $locationQuery->with('building');
        }, 'transaction' => function($transactionQuery){
            $transactionQuery->with(['employee']);
        }])->orderBy('created_at', 'desc')->get();

        return (request()->expectsJson()) ? response()->json([
            'assets' => $assets
        ]) : view('dashboard.assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assetStatus = AssetStatus::all();
        $asset_categories = FixedAsset::all();

        $buildings = Building::with(['rooms'])->get();

        return view('dashboard.assets.create', compact('asset_categories', 'assetStatus', 'buildings'));
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
            'name' => 'required|min:2',
            'tag' => 'nullable|unique:assets,tag',
            'serial_number' => 'nullable|unique:assets,serial_number',
            'purchase_date' => 'nullable|date'
        ]);

        $asset = new Asset;

        $asset->name = $request->name;
        $asset->photo = ($request->photo) ? 'storage/'.request()->photo->store('assets', 'public') : null;
        $asset->model = $request->model;
        $asset->serial_number = $request->serial_number;
        $asset->description = $request->description;
        $asset->tag = $request->tag;


        $asset->purchase_date = $request->purchase_date;
        $asset->purchase_cost = $request->purchase_cost;

        $asset->depreciable = $request->depreciable ?? '0';
        $asset->depreciation_start_date = $request->depreciation_start_date;
        $asset->useful_life = $request->useful_life;
        $asset->salvage_value = $request->salvage_value;


        $asset->account_id = $request->asset_category;
        $asset->location_id = $request->location;
        $asset->asset_status_id = $request->asset_status ?? null;

        $asset->save();
        
        return back()->withInput()->with('created', 'Asset add successfully .....');
    }

    /**
     * Display the specified resource.
     *
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = Asset::with(['type', 'vendor', 'location' => function($locationQuery){
            $locationQuery->with('building');
        }, 'status', 'transactions' => function($transactionsQuery){
            $transactionsQuery->orderBy('date', 'desc')->with(['employee:id,first_name,last_name', 'checkin']);
        }])->findOrFail($id);

        return (request()->expectsJson()) ? response()->json([
            'asset' => $asset
        ]) : view('dashboard.assets.show', compact('asset'));
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
        $asset = Asset::whereId($id)->first();

        $asset->name = $request->name;
        $asset->serial_number = $request->serial_number;
        $asset->description = $request->description;
        $asset->asset_type_id = $request->asset_type;
        $asset->location_id = $request->location;
        $asset->custodian_id = $request->custodian;

        $asset->save();
        return back()->withInput()->with('updated', 'Asset details updated successfully ....');
    }

    public function updateFinance(Request $request, $id)
    {
        $asset = Asset::whereId($id)->first();

        $asset->purchase_date = $request->purchase_date;
        $asset->purchase_cost = $request->purchase_cost;
        $asset->salvage_value = $request->salvage_value;

        $asset->save();
        return back()->withInput()->with('updated', 'Asset finance details updated successfully ....');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Asset::whereId($id)->delete();
        return back()->with('deleted', 'Asset deleted successfully ...');
    }

    /**
     * Dispose depreciated assets
     * 
     * @return \Illuminate\Http\Response
     */

     public function dispose($id)
     {
        $asset = Asset::find($id);
        $asset->dispose();
        return back();
     }

     /**
      * Undispose disposed assets
      * @return \Illuminate\Http\Response
      */
     public function undispose($id)
     {
        $asset = Asset::withDisposed()->find($id);
        $asset->undispose();
        return back();
     }

     /**
      * Show a lising of disposed assets
      * @return \Illuminate\Http\Response
      */
     public function disposed()
     {
        return Asset::onlyDisposed()->get();
     }

     public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);

        Asset::whereId($id)->update([
            'photo' => 'storage/'.request()->photo->store('assets', 'public')
        ]);

        return ($request->expectsJson()) ? response()->json(['success' => true, 'message' => 'Photo updated successfully'], 200) : back()->withInput()->with('updated', 'Asset Photo changed successfully');
    }


    //Export assets
    public function export()
    {
        return Excel::download(new AssetExport(), Carbon::now()->format('Y-m-d').'_assets.xlsx');
    }

}
