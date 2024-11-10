<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;

use App\Models\Asset\Asset;
use App\Models\Asset\DepreciationSchedule;
use Carbon\Carbon;

class DepreciationScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth', 'usertype:employee|master'
        ]);
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    { 
        $asset = Asset::with(['type', 'depreciationSchedules'])->findOrFail($id);

        $depreciable_cost = ($asset->salvage_value) ? ($asset->purchase_cost - $asset->salvage_value) : $asset->purchase_cost;
        $depreciation_rate = (1/$asset->useful_life);
        $start_date = Carbon::parse($asset->depreciation_start_date);
        
        $today =  Carbon::parse(today());
        $count_years = $start_date->diffInYears($today);
        $years =  range(1, ($asset->useful_life >= $count_years) ? $count_years : $asset->useful_life);

        if ($asset->depreciation_method == 'slm') {
            for ($i=0; $i < count($years) ; $i++) { 
                # code...
                DepreciationSchedule::updateOrCreate(['asset_id' => $asset->id, 'year' => $years[$i]],[
                    'asset_id' => $asset->id,
                    'year' => $years[$i],
                    'opening_book_value' => ($years[$i] > 1) ? ($depreciable_cost - (($depreciation_rate * $depreciable_cost) * ($years[$i] - 1))) : $depreciable_cost,
                    'depreciation_expense' => ($depreciation_rate * $depreciable_cost),
                    'accumulated_depreciation_expense' => ($depreciation_rate * $depreciable_cost) * $years[$i],
                    'closing_book_value' => $depreciable_cost - (($depreciation_rate * $depreciable_cost) * $years[$i])
                ]);
            }

        }

        return view('dashboard.assets.depreciation.schedule.index', compact('asset'));

    }
}
