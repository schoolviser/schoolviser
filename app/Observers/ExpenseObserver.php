<?php

namespace App\Observers;

use App\Models\Accounting\Coa\Expense;

use App\Jobs\Accounting\Expense\SynchronizeTermlyExpenseSummaryJob;

//Cache Managers
use App\Cache\CoaCacheManager;

class ExpenseObserver
{
    /**
     * Handle the expense "created" event.
     *
     * @param  \App\Models\Accounting\Coa\Expense  $expense
     * @return void
     */
    public function created(Expense $expense)
    {
        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

        //CLear expense accounts from cache
        CoaCacheManager::clearExpensesFromCache();
    }

    /**
     * Handle the expense "updated" event.
     *
     * @param  \App\Models\Accounting\Coa\Expense  $expense
     * @return void
     */
    public function updated(Expense $expense)
    {
        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

        //CLear expense accounts from cache
        CoaCacheManager::clearExpensesFromCache();
    }

    /**
     * Handle the expense "deleted" event.
     *
     * @param  \App\Models\Accounting\Coa\Expense  $expense
     * @return void
     */
    public function deleted(Expense $expense)
    {
        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();


        //CLear expense accounts from cache
        CoaCacheManager::clearExpensesFromCache();
    }

    /**
     * Handle the expense "restored" event.
     *
     * @param  \App\Models\Accounting\Coa\Expense  $expense
     * @return void
     */
    public function restored(Expense $expense)
    {
        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

        //CLear expense accounts from cache
        CoaCacheManager::clearExpensesFromCache();
    }

    /**
     * Handle the expense "force deleted" event.
     *
     * @param  \App\Models\Accounting\Coa\Expense  $expense
     * @return void
     */
    public function forceDeleted(Expense $expense)
    {
        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

        //CLear expense accounts from cache
        CoaCacheManager::clearExpensesFromCache();
    }
}
