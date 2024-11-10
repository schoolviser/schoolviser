<?php

namespace App\Observers;

use App\Models\Accounting\Expense\ExpenseTransaction;

//Jobs
use App\Jobs\Accounting\Expense\PopulateMonthlyExpenseSummary;
use App\Jobs\Accounting\Expense\SynchronizeTermlyExpenseSummaryJob;
use App\Jobs\Accounting\SynchronizeBankingJob;


class ExpenseTransactionObserver
{
    /**
     * Handle the expense transaction "created" event.
     *
     * @param  \App\Models\Accounting\Expense\ExpenseTransaction  $expenseTransaction
     * @return void
     */
    public function created(ExpenseTransaction $expenseTransaction)
    {
        //Populate monthly expense summary
        PopulateMonthlyExpenseSummary::dispatch(term()->id);

        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

        //Sync banking with sums
        SynchronizeBankingJob::dispatch($expenseTransaction->bank_id, 'withdrawals');
    }

    /**
     * Handle the expense transaction "updated" event.
     *
     * @param  \App\Models\Accounting\Expense\ExpenseTransaction  $expenseTransaction
     * @return void
     */
    public function updated(ExpenseTransaction $expenseTransaction)
    {
        //Populate monthly expense summary
        PopulateMonthlyExpenseSummary::dispatch(term()->id);

        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

         //Sync banking with sums
         SynchronizeBankingJob::dispatch($expenseTransaction->bank_id, 'withdrawals');

    }

    /**
     * Handle the expense transaction "deleted" event.
     *
     * @param  \App\Models\Accounting\Expense\ExpenseTransaction  $expenseTransaction
     * @return void
     */
    public function deleted(ExpenseTransaction $expenseTransaction)
    {
        //Populate monthly expense summary
        PopulateMonthlyExpenseSummary::dispatch(term()->id);

        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

         //Sync banking with sums
         SynchronizeBankingJob::dispatch($expenseTransaction->bank_id, 'withdrawals');
    }

    /**
     * Handle the expense transaction "restored" event.
     *
     * @param  \App\Models\Accounting\Expense\ExpenseTransaction  $expenseTransaction
     * @return void
     */
    public function restored(ExpenseTransaction $expenseTransaction)
    {
        //Populate monthly expense summary
        PopulateMonthlyExpenseSummary::dispatch(term()->id);

        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

         //Sync banking with sums
         SynchronizeBankingJob::dispatch($expenseTransaction->bank_id, 'withdrawals');
    }

    /**d
     * Handle the expense transaction "force deleted" event.
     *
     * @param  \App\Models\Accounting\Expense\ExpenseTransaction  $expenseTransaction
     * @return void
     */
    public function forceDeleted(ExpenseTransaction $expenseTransaction)
    {
        //Populate monthly expense summary
        PopulateMonthlyExpenseSummary::dispatch(term()->id);
        
        //Syn termly expense summary
        SynchronizeTermlyExpenseSummaryJob::dispatch();

         //Sync banking with sums
         SynchronizeBankingJob::dispatch($expenseTransaction->bank_id, 'withdrawals');
    }
}
