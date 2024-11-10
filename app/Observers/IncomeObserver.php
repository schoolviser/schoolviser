<?php

namespace App\Observers;


use App\Models\Accounting\Income;

//Jobs
use App\Jobs\ProcessRevenue;

class IncomeObserver
{
    /**
     * Handle the income "created" event.
     *
     * @param  \App\Income  $income
     * @return void
     */
    public function created(Income $income)
    {
        //Populate termly or yearly revenue summaries
        ProcessRevenue::dispatch($income->account_id);
        //Check if revenue account is child to populate parent total revenue
    }

    /**
     * Handle the income "updated" event.
     *
     * @param  \App\Income  $income
     * @return void
     */
    public function updated(Income $income)
    {
        //Populate termly or yearly revenue summaries
        ProcessRevenue::dispatch($income->account_id);
    }

    /**
     * Handle the income "deleted" event.
     *
     * @param  \App\Income  $income
     * @return void
     */
    public function deleted(Income $income)
    {
        //Populate termly or yearly revenue summaries
        ProcessRevenue::dispatch($income->account_id);
    }

    /**
     * Handle the income "restored" event.
     *
     * @param  \App\Income  $income
     * @return void
     */
    public function restored(Income $income)
    {
        //Populate termly or yearly revenue summaries
        ProcessRevenue::dispatch($income->account_id);
    }

    /**
     * Handle the income "force deleted" event.
     *
     * @param  \App\Income  $income
     * @return void
     */
    public function forceDeleted(Income $income)
    {
        //Populate termly or yearly revenue summaries
        ProcessRevenue::dispatch($income->account_id);
    }
}
