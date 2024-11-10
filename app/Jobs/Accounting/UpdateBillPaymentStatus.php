<?php

namespace App\Jobs\Accounting;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Bill\Bill;

class UpdateBillPaymentStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $billId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($billId)
    {
        $this->billId = $billId;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bill = Bill::with(['payments'])->whereId($this->billId)->first();

        if($bill){
            $total_paid = $bill->payments->sum('amount');

            if ($total_paid >= $bill->amount) {
                $bill->payment_status = Bill::STATUS_PAID;
                $bill->amount_paid = $total_paid;
                $bill->save();
            }elseif($total_paid < $bill->amount && $total_paid > 0){
                $bill->amount_paid = $total_paid;
                $bill->payment_status = Bill::STATUS_PARTIALLY_PAID;
                $bill->save();
            }
        }
    }
}
