<?php

namespace App\Jobs\Accounting\Expense;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Accounting\Expense\MonthlyExpenseSummary as MonthlyExpense;
use App\Models\Accounting\Expense\ExpenseTransaction;

use App\Cache\MonthlyExpenseSummaryCacheManager;

use App\Models\Any;

class PopulateMonthlyExpenseSummary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $term_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($term_id)
    {
        $this->term_id = $term_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $term = (!is_null($this->term_id)) ? term($this->term_id) : term();

        //Get the month btn start and end date of the term
        $period = \Carbon\CarbonPeriod::create(term()->start_date, '1 month', $term->end_date);
        $months = array();
        //Create month array
        foreach ($period as $dt) {
            $months[] = $dt->format("m");
        }

        foreach ($months as $month) {
            # code...
            $expenses = ExpenseTransaction::period($term->id, 'term')->whereMonth('date', $month)->with('items')->get()->map(function($item, $key){
                return new Any([
                    'amount' => $item->items->map(function($item, $key){
                        return new Any([
                            'amount' => ($item->quantity * $item->rate)
                        ]);
                    })->sum('amount')
                ]);
            });
        
            MonthlyExpense::updateOrCreate(['term_id' => $term->id, 'month' => $month], ['month' => $month, 'term_id' => $term->id, 'amount' => $expenses->sum('amount')]);
        }

        //Clear current term montly expense cache summary
        MonthlyExpenseSummaryCacheManager::clearCurrentTermExpenseSummaryFromCache();
            
    }
}
