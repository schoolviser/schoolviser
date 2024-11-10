<?php

namespace App\Jobs\Accounting;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Accounting\LiabilitySummary;
use App\Models\Accounting\Coa\Liability;

use App\Models\Any;


class SummarizeBillsForCurrentPeriod implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Liability::with(['bills','children' => function($childrenQuery){
            return $childrenQuery->with(['bills']);
        }])->get()->map(function($item, $key){
            $children = $item->children->map(function($item, $key){
                return new Any([
                    'id' => $item->id,
                    'name' => $item->name,
                    'amount' => ($item->bills->sum('amount') - $item->bills->sum('amount_paid'))
                ]);
            });
            return new Any([
                'id' => $item->id,
                'name' => $item->name,
                'amount' => ($item->bills->sum('amount') - $item->bills->sum('amount_paid')) + $children->sum('amount')
            ]);
        })->map(function($item, $key){
            LiabilitySummary::updateOrCreate(['accounting_period_id' => period()->id, 'account_id' => $item->id],[
                'accounting_period_id' => period()->id,
                'account_id' => $item->id,
                'amount' => $item->amount
            ]);
        });
    }
}
