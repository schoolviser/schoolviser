<?php

namespace App\Defaults;

use App\Models\Any;
use App\Models\ModeOfPayment;

class ModeOfPaymentDefaults
{

    public function load()
    {
        $modes = $this->get();
        
        $modes->map(function($item, $key){
            ModeOfPayment::updateOrCreate([
                'name' => $item->name
            ]);
        });
        
    }


    public function get()
    {
        return collect([
            new Any([
                'name' => 'Cheque'
            ]),
            new Any([
                'name' => 'Cash'
            ]),
            new Any([
                'name' => 'Credit/Debit Card'
            ]),
            new Any([
                'name' => 'Online Payment Gateways'
            ])
        ]);
    }
}
