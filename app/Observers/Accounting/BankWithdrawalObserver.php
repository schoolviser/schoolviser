<?php

namespace App\Observers\Accounting;

use App\Models\Accounting\BankWithdrawal;
use App\Models\Accounting\BankDeposit;
use App\Jobs\Accounting\SynchronizeBankingJob;
use App\Models\Accounting\BankTransaction;

class BankWithdrawalObserver
{
    /**
     * Handle the bank withdrawal "created" event.
     *
     * @param  \App\Models\Accounting\BankWithdrawal  $bankWithdrawal
     * @return void
     */
    public function created(BankWithdrawal $bankWithdrawal)
    {
        //Record or update deposit transaction
        $bankWithdrawal->transaction()->updateOrCreate(['transaction_type_id' => $bankWithdrawal->id, 'transaction_type' => BankWithdrawal::class],[
            'transaction_type_id' => $bankWithdrawal->id,
            'transaction_type' => BankWithdrawal::class,
            'bank_id' => $bankWithdrawal->account_id,
            'accounting_period_id' => $bankWithdrawal->accounting_period_id,
            'date' => $bankWithdrawal->date
        ]);

        SynchronizeBankingJob::dispatchNow($bankWithdrawal->account_id);
    }

    /**
     * Handle the bank withdrawal "updated" event.
     *
     * @param  \App\Models\Accounting\BankWithdrawal  $bankWithdrawal
     * @return void
     */
    public function updated(BankWithdrawal $bankWithdrawal)
    {
        //Record or update deposit transaction
        $bankWithdrawal->transaction()->updateOrCreate(['transaction_type_id' => $bankWithdrawal->id, 'transaction_type' => BankWithdrawal::class],[
            'transaction_type_id' => $bankWithdrawal->id,
            'transaction_type' => BankWithdrawal::class,
            'bank_id' => $bankWithdrawal->account_id,
            'accounting_period_id' => $bankWithdrawal->accounting_period_id,
            'date' => $bankWithdrawal->date
        ]);

        SynchronizeBankingJob::dispatch($bankWithdrawal->account_id);
    }

    /**
     * Handle the bank withdrawal "deleted" event.
     *
     * @param  \App\Models\Accounting\BankWithdrawal  $bankWithdrawal
     * @return void
     */
    public function deleted(BankWithdrawal $bankWithdrawal)
    {
        BankTransaction::whereTransactionType(BankWithdrawal::class)->whereTransactionTypeId($bankWithdrawal->id)->delete();

        SynchronizeBankingJob::dispatch($bankWithdrawal->account_id);
    }

    /**
     * Handle the bank withdrawal "restored" event.
     *
     * @param  \App\Models\Accounting\BankWithdrawal  $bankWithdrawal
     * @return void
     */
    public function restored(BankWithdrawal $bankWithdrawal)
    {
        //Record or update deposit transaction
        $bankWithdrawal->transaction()->updateOrCreate(['transaction_type_id' => $bankWithdrawal->id, 'transaction_type' => BankWithdrawal::class],[
            'transaction_type_id' => $bankWithdrawal->id,
            'transaction_type' => BankWithdrawal::class,
            'bank_id' => $bankWithdrawal->account_id,
            'accounting_period_id' => $bankWithdrawal->accounting_period_id,
            'date' => $bankWithdrawal->date
        ]);

        SynchronizeBankingJob::dispatch($bankWithdrawal->account_id);
    }

    /**
     * Handle the bank withdrawal "force deleted" event.
     *
     * @param  \App\Models\Accounting\BankWithdrawal  $bankWithdrawal
     * @return void
     */
    public function forceDeleted(BankWithdrawal $bankWithdrawal)
    {
        SynchronizeBankingJob::dispatch($bankWithdrawal->account_id);
    }
}
