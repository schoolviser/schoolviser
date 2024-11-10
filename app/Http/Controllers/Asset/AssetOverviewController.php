<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Accounting\Coa\FixedAsset;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssetOverviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $assets = FixedAsset::withCount(['assets'])->with(['currentAssetSummary'])->get();
       return view('dashboard.assets.overview', compact('assets'));
    }
}
