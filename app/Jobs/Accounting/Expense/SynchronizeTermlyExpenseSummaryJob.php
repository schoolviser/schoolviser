<?php

namespace App\Jobs\Accounting\Expense;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Accounting\Expense\TermlyExpenseSummary;
use App\Models\Accounting\Coa\Expense;
use App\Support\Models\Any;


class SynchronizeTermlyExpenseSummaryJob implements ShouldQueue
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
        $expenses =  Expense::with(['items' => function($itemQuery){
            $itemQuery->whereHas('currentTermTransaction');
        },'children' => function($childrenQuery){
            $childrenQuery->with(['items' => function($itemQuery){
                $itemQuery->whereHas('currentTermTransaction');
            }, 'children' => function($childrenQuery){
                $childrenQuery->with(['items' => function($itemQuery){
                    $itemQuery->whereHas('currentTermTransaction');
                }]);
            }]);
        }])->get()->map(function($item, $key){
            return new Any([
                'id' => $item->id,
                'name' => $item->name,
                'amount' => $item->items->map(function($item, $key){
                    return new Any(['amount' => ($item->quantity * $item->rate)]);
                })->sum('amount') + $item->children->map(function($item, $key){
                    return new Any([
                        'id' => $item->id,
                        'name' => $item->name,
                        'amount' => $item->items->map(function($item, $key){
                            return  new Any(['amount' => ($item->quantity * $item->rate)]);
                        })->sum('amount') + $item->children->map(function($item, $key){
                            return new Any([
                                'id' => $item->id,
                                'name' => $item->name,
                                'amount' => $item->items->map(function($item, $key){
                                    return new Any(['amount' => ($item->quantity * $item->rate)]);
                                })->sum('amount')
                            ]);
                        })->sum('amount')
                    ]);
                })->sum('amount')
            ]);
        });

        $expenses->map(function($item, $key){
          //Sync termly expense summary for the chart of accounts
          TermlyExpenseSummary::updateOrCreate(['account_id' => $item->id,'term_id' => term()->id],[
            'account_id' => $item->id,
            'term_id' => term()->id,
            'amount' => $item->amount,
            'budget' => '0'
          ]);
        });
    }
}
