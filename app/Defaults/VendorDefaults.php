<?php

namespace App\Defaults;

use App\Models\Any;
use App\Models\Vendor\Vendor;


class VendorDefaults
{


    public function load()
    {
        $this->get()->map(function($item, $key){
            Vendor::updateOrCreate(['name' => $item->name],[
                'name' => $item->name
            ]);
        });
    }

    public function get()
    {
        return collect([
            new Any([
                'name' => 'Airtel Uganda',
            ]),
            new Any([
                'name' => 'MTN Uganda'
            ])
        ]);
    }
   
}