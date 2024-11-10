<?php

namespace App\Observers\Accounting;

use App\Models\Accounting\BankDeposit;

use App\Jobs\Accounting\SynchronizeBankingJob;
use App\Models\Accounting\BankTransaction;


class BankDepositObserver
{
    /**
     * Handle the bank deposit "created" event.
     *
     * @param  \App\Models\Accounting\BankDeposit  $bankDeposit
     * @return void
     */
    public function created(BankDeposit $bankDeposit)
    {
        //Record or update deposit transaction
        $bankDeposit->transaction()->updateOrCreate(['transaction_type_id' => $bankDeposit->id, 'transaction_type' => BankDeposit::class],[
            'transaction_type_id' => $bankDeposit->id,
            'transaction_type' => BankDeposit::class,
            'bank_id' => $bankDeposit->account_id,
            'accounting_period_id' => $bankDeposit->accounting_period_id,
            'date' => $bankDeposit->date
        ]);

        SynchronizeBankingJob::dispatchNow($bankDeposit->account_id);
    }

    /**
     * Handle the bank deposit "updated" event.
     *
     * @param  \App\Models\Accounting\BankDeposit  $bankDeposit
     * @return void
     */
    public function updated(BankDeposit $bankDeposit)
    {
       //Record or update deposit transaction
       $bankDeposit->transaction()->updateOrCreate(['transaction_type_id' => $bankDeposit->id, 'transaction_type' => BankDeposit::class],[
            'transaction_type_id' => $bankDeposit->id,
            'transaction_type' => BankDeposit::class,
            'bank_id' => $bankDeposit->account_id,
            'accounting_period_id' => $bankDeposit->accounting_period_id,
            'date' => $bankDeposit->date
        ]);

        SynchronizeBankingJob::dispatch($bankDeposit->account_id);
    }

    /**
     * Handle the bank deposit "deleted" event.
     *
     * @param  \App\Models\Accounting\BankDeposit  $bankDeposit
     * @return void
     */
    public function deleted(BankDeposit $bankDeposit)
    {
        BankTransaction::whereTransactionType(BankDeposit::class)->whereTransactionTypeId($bankDeposit->id)->delete();

        SynchronizeBankingJob::dispatch($bankDeposit->account_id);
    }

    /**
     * Handle the bank deposit "restored" event.
     *
     * @param  \App\Models\Accounting\BankDeposit  $bankDeposit
     * @return void
     */
    public function restored(BankDeposit $bankDeposit)
    {
        //Record or update deposit transaction
       $bankDeposit->transaction()->updateOrCreate(['transaction_type_id' => $bankDeposit->id, 'transaction_type' => BankDeposit::class],[
            'transaction_type_id' => $bankDeposit->id,
            'transaction_type' => BankDeposit::class,
            'bank_id' => $bankDeposit->account_id,
            'accounting_period_id' => $bankDeposit->accounting_period_id,
            'date' => $bankDeposit->date
        ]);

        SynchronizeBankingJob::dispatch($bankDeposit->account_id);
    }

    /**
     * Handle the bank deposit "force deleted" event.
     *
     * @param  \App\Models\Accounting\BankDeposit  $bankDeposit
     * @return void
     */
    public function forceDeleted(BankDeposit $bankDeposit)
    {
        $bankDeposit->transaction()->delete();

        SynchronizeBankingJob::dispatch($bankDeposit->account_id);
    }
}
