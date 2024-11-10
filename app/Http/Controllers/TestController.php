<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Any;

use Carbon\Carbon;

use App\Models\Accounting\Coa\Bank;
use App\Models\Accounting\BankDeposit;


class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {

        $hh = Bank::whereId(2)->with(['deposits' => function($tt){
            $tt->whereChequeNo('200');
        },'expenses' => function($query){
            $query->with('items')->whereChequeNo(200);
        }])->first();

        return ($hh->deposits->sum('amount') - $hh->expenses->sum('amount'));
    }
    
}
