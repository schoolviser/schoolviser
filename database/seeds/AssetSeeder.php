<?php

use Illuminate\Database\Seeder;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetType;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\AssetLocation;
use App\Vendor;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asset_types = config('defaults.asset_types');

        for ($i=0; $i < count($asset_types) ; $i++) { 
            $asset = AssetType::updateOrCreate([
                'name' => $asset_types[$i]
            ]);
           
        }
       
    }
}
