<?php

use Illuminate\Database\Seeder;

use App\Models\Bill\Bill;

use App\MOdels\Coa;

use Carbon\Carbon;


class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Coa::where('type', 'liability')->first();

        $bill = new Bill;

        $bill->amount = '200000';
        $bill->due_date = Carbon::tomorrow();
        $bill->my_due_date = Carbon::tomorrow();
        $bill->invoice_no = '4368297';
        $bill->vendor_id = 1;
        $bill->account_id = ($account) ? $account->id : null;

        //$bill->save();
    }
}
