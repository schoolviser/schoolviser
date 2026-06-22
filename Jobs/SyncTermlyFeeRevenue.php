<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Fee\FeeCategory;
use App\Models\Accounting\TermlyAccrualRevenue;
use App\Models\Any;

class SyncTermlyFeeRevenue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $term;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($term = null, $account_id = null)
    {
        ($term) ?  $term : term();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        FeeCategory::whereHas('account')->with(['account', 'fees' => function($feeQuery){
            $feeQuery->current()->withCount(['students']);
        }, 'discounts' => function($discountQuery){
            $discountQuery->whereHas('termlyRegistration', function($termlyRegistrationQuery){
                $termlyRegistrationQuery->current();
            });
        }])->get()->map(function($item, $key){
            $discounts = $item->discounts->map(function($item, $key){
                $amount = ($item->mode == 'fixed') ? $item->amount : (($item->percentage/100) * ($item->amount ?? 0));
                return new Any([
                    'id' => $item->id,
                    'amount' => $amount
                ]);
            });
            $fees = $item->fees->map(function($item, $key){
                return new Any([
                    'id' => $item->id, //Fees id
                    'amount' => ($item->amount * $item->students_count)
                ]);
            });
            return new Any([
                'id' => $item->account->id,
                'name' => $item->account->name,
                'amount' => ($fees->sum('amount') - $discounts->sum('amount'))
                
            ]);
        })->map(function($item, $key){
            TermlyAccrualRevenue::updateOrCreate(['term_id' => term()->id, 'account_id' => $item->id],['amount' => $item->amount, 'term_id' => term()->id, 'account_id' => $item->id]);
            return $item;
        });
    }
}
