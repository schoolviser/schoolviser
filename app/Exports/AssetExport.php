<?php

namespace App\Exports;

use App\Models\Asset\Asset;
use App\Support\Models\Any;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class AssetExport implements FromCollection, WithHeadings
{

    public function __construct()
    {
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $assets = Asset::with(['location' => function($locationQuery){
         $locationQuery->with('building');
        }, 'type'])->get();

        return collect($assets)->map(function($item, $key){
            return new Any([
                'serial_number' => $item->serial_number,
                'name' => $item->name,
                'purchase_cost' => $item->purchase_cost,
                'purchase_date' => $item->purchase_date,
                'location' => ($item->location) ? $item->location->name : '',
                'asset_type' => ($item->type) ? $item->type->name : '',
            ]);
        });
    }

    public function headings(): array
    {
        return [
            'Serial Number',
            'Name',
            'Purchase Cost',
            'Purchase Date',
            'Location',
            'Asset Type'
        ];
    }
}
