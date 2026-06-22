<?php

namespace App\Jobs\Accounting;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


use App\Models\Accounting\Coa\Bank;
use App\Models\Accounting\BankedSchoolFeeSum;
use App\Models\Accounting\BankedDepositSum;
use App\Models\Accounting\BankExpenseWithdrawalSum;
use App\Models\Accounting\BankWithdrawalSum;

class SynchronizeBankingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bank;

    /**
     * What to sync - deposits or withdrawals
     */
    protected $what = 'deposits';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bank = null, $what = 'deposits')
    {
        $this->bank = $bank;
        $this->what = $what;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(!is_null($this->bank)){
            $this->syncBank();
        }else{
            $this->syncBanks();
        }
    }

    private function syncBank()
    {
        $item = Bank::with(['currentFeeDeposits', 'currentDeposits', 'currentExpenses', 'currentWithdrawals'])->whereId($this->bank)->first();

         BankedSchoolFeeSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentFeeDeposits->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
        ]);
            
        BankedDepositSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
            'amount' => $item->currentDeposits->sum('amount'),
            'accounting_period_id' => period()->id,
            'bank_id' => $item->id
        ]);

        BankExpenseWithdrawalSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
            'amount' => $item->currentExpenses->sum('amount'),
            'accounting_period_id' => period()->id,
            'bank_id' => $item->id
        ]);

        BankWithdrawalSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
            'amount' => $item->currentWithdrawals->sum('amount'),
            'accounting_period_id' => period()->id,
            'bank_id' => $item->id
        ]);

    }

    private function syncBanks()
    {
        $banks = Bank::with(['currentFeeDeposits', 'currentDeposits', 'currentExpenses', 'currentWithdrawals'])->get();
        $banks->map(function($item, $key){

            BankedSchoolFeeSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentFeeDeposits->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
            ]);
            
            BankedDepositSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentDeposits->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
            ]);

            BankExpenseWithdrawalSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentExpenses->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
            ]);

            BankWithdrawalSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentWithdrawals->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
            ]);

        });
    }
}
