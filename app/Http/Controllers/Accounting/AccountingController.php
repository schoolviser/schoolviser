<?php

/**
 * Schoolviser (https://schoolviser.com).
 *
 * @link https://schoolviser.com
 *
 * @copyright Copyright (c) 2023. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://schoolviser.com/licensing/
 */

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Carbon\Carbon;

//Repos
use App\Repository\MonthlyExpenseSummaryRepository;
use App\Repository\AccountingPeriodRepository;


//Models
use App\Models\Any;
use App\Models\Accounting\Coa\Revenue;
use App\Models\Accounting\Coa\Expense;
use App\Models\Accounting\Coa\FixedAsset;
use App\Models\Accounting\Coa\Liability;

use App\Models\Accounting\TermlyAccrualRevenue;
use App\Models\Accounting\TermlyReceivable;



use App\Jobs\ProcessTermlyTutionRevenue;


use App\TuitionRevenue;
use App\OtherRevenue;

use App\Jobs\ProcessRevenue;
use App\Models\Accounting\Coa\Bank;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AccountingController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupedExpenses =  collect(Expense::current()->orderBy('date', 'asc')->get())->groupBy(function($expense, $key){
                return Carbon::parse($expense->date)->format('M');
        });

        $expenseSummary = $groupedExpenses->map(function($item, $key){
            return $item->sum('amount');
        })->toArray();

        return view('dashboard.accounting.index', compact(['expenseSummary']));
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        

        //Monthly Expense summary for the current term
        $monthlyExpenseSummary = app(MonthlyExpenseSummaryRepository::class)->current()->get()->toArray();

        //Accrual Revenue
        $revenue =  Revenue::isParent()->with(['termlyAccrualRevenues' => function($termlyAccrualRevenuesQuery){
            $termlyAccrualRevenuesQuery->current();
        },'children' => function($childrenQuery){
            $childrenQuery->with(['termlyAccrualRevenues' => function($termlyAccrualRevenuesQuery){
                $termlyAccrualRevenuesQuery->current();
            },'children' => function($childrenQuery){
                $childrenQuery->with(['termlyAccrualRevenues' => function($termlyAccrualRevenuesQuery){
                    $termlyAccrualRevenuesQuery->current();
                }]);
            }]);
        }])->get()->map(function($item, $key){
            return new Any([
                'id' => $item->id,
                'name' => $item->name,
                'amount' => $item->termlyAccrualRevenues->sum('amount'),
                'children' => $item->children->map(function($item, $key){
                    return new Any([
                        'id' => $item->id,
                        'name' => $item->name,
                        'amount' => $item->termlyAccrualRevenues->sum('amount'),
                        'children' => $item->children->map(function($item, $key){
                            return new Any([
                                'id' => $item->id,
                                'name' => $item->name,
                                'amount' => $item->termlyAccrualRevenues->sum('amount')
                            ]);
                        })
                    ]);
                }),
            ]);
        });
        //End Accrual revenue

        $expense_summary = 'termlyExpenseSummary';

        $expenses = Expense::isParent()->with(['termlyExpenseSummary' => function($termlyExpenseSummaryQuery){
            $termlyExpenseSummaryQuery->current('term');
        }, 'children' => function($childrenQuery){
            $childrenQuery->with(['termlyExpenseSummary' => function($termlyExpenseSummaryQuery){
                $termlyExpenseSummaryQuery->current('term');
            }, 'children' => function($childrenQuery){
                $childrenQuery->with(['termlyExpenseSummary' => function($termlyExpenseSummaryQuery){
                    $termlyExpenseSummaryQuery->current('term');
                }]);
            }]);
        }])->get()->map(function($item, $key){
            return new Any([
                'id' => $item->id,
                'name' => $item->name,
                'amount' => ($item->termlyExpenseSummary) ? $item->termlyExpenseSummary->amount : 0,
                'children' => $item->children->map(function($item, $key){
                    return new Any([
                        'id' => $item->id,
                        'name' => $item->name,
                        'amount' => ($item->termlyExpenseSummary) ? $item->termlyExpenseSummary->amount : 0,
                        'children' => $item->children->map(function($item, $key){
                            return new Any([
                                'id' => $item->id,
                                'name' => $item->name,
                                'amount' => ($item->termlyExpenseSummary) ? $item->termlyExpenseSummary->amount : 0,
                            ]);
                        })
                    ]);
                })
            ]);
        })->reject(function($item){
            return $item->amount == 0;
        });

        $banks = Bank::with(['currentBankedSchoolFeeSum','currentBankedDepositSum', 'currentExpenseWithdrawalSum', 'currentWithdrawalSum', 'currentIncomeSum'])->get();
        $fixed_assets = FixedAsset::with(['currentAssetSummary'])->get();


        $receivables =  Revenue::isParent()->with(['termlyReceivables' => function($termlyReceivablesQuery){
            $termlyReceivablesQuery->current('term');
        },'children' => function($childrenQuery){
            $childrenQuery->with(['termlyReceivables' => function($termlyReceivablesQuery){
                $termlyReceivablesQuery->current('term');
            },'children' => function($childrenQuery){
                $childrenQuery->with(['termlyReceivables' => function($termlyReceivablesQuery){
                    $termlyReceivablesQuery->current('term');
                }]);
            }]);
        }])->get()->map(function($item, $key){
            return new Any([
                'id' => $item->id,
                'name' => $item->name,
                'amount' => $item->termlyReceivables->sum('amount'),
                'children' => $item->children->map(function($item, $key){
                    return new Any([
                        'id' => $item->id,
                        'name' => $item->name,
                        'amount' => $item->termlyReceivables->sum('amount'),
                        'children' => $item->children->map(function($item, $key){
                            return new Any([
                                'id' => $item->id,
                                'name' => $item->name,
                                'amount' => $item->termlyReceivables->sum('amount')
                            ]);
                        })
                    ]);
                }),
            ]);
        })->reject(function($item){
            return $item->amount == 0;
        });

        $accountsPayable = Liability::accountsPayable()->isParent()->with(['liabilitySummaries','children' => function($childrenQuery){
            return $childrenQuery->with(['liabilitySummaries']);
        }])->get()->map(function($item, $key){
            return new Any([
                'id' => $item->id,
                'name' => $item->name,
                'amount' => $item->liabilitySummaries->sum('amount'),
                'children' => $item->children->map(function($item, $key){
                    return new Any([
                        'id' => $item->id,
                        'name' => $item->name,
                        'amount' => $item->liabilitySummaries->sum('amount'),
                    ]);
                })
            ]);
        });

        $liabilities = collect([
            new Any([
                'name' => 'Current Liabilities',
                'accounts' => collect([
                    new Any([
                        'name' => 'Accounts Payable',
                        'amount' => $accountsPayable->sum('amount'),
                        'accounts' => $accountsPayable
                    ]),
                    new Any([
                        'name' => 'Accrued Expenses',
                        'amount' => '0',
                        'accounts' => collect([
                            new Any([
                                'name' => 'expense accounts here',
                            'amount' => '0'
                            ])
                        ])
                    ]),
                    new Any([
                        'name' => 'Defered Revenue',
                        'amount' => '0',
                        'accounts' => collect([])
                    ])
                ])
            ]),
            new Any([
                'name' => 'Long Term Liabilities',
                'accounts' => collect([])
            ])
        ]);


        $assets =  collect([
            new Any([
                'name' => 'banks',
                'accounts' => $banks->map(function($item, $key){
                    $fees = ($item->currentBankedSchoolFeeSum) ? $item->currentBankedSchoolFeeSum->amount : 0;
                    $deposits = ($item->currentBankedDepositSum) ? $item->currentBankedDepositSum->amount : 0;
                    $expenses = ($item->currentExpenseWithdrawalSum) ? $item->currentExpenseWithdrawalSum->amount : 0;
                    $withdrawals = ($item->currentWithdrawalSum) ? $item->currentWithdrawalSum->amount : 0;
                    $income = ($item->currentIncomeSum) ? $item->currentIncomeSum->amount : 0;
                    return new Any([
                        'name' => $item->name,
                        'amount' =>  (($fees + $deposits + $income) - ($expenses + $withdrawals)),
                        'children' => []
                    ]);
                })
            ]),
            new Any([
                'name' => 'Accounts Receivable',
                'accounts' => $receivables
            ]),
            new Any([
                //use the inventory categories and inventory stock
                'name' => 'Inventory',
                'accounts' => collect([
                    new Any([
                        'name' => 'Posho',
                        'amount' => '36257878'
                    ]),
                    new Any([
                        'name' => 'Beans',
                        'amount' => '0'
                    ]),
                    new Any([
                        'name' => 'Gloves',
                        'amount' => '0'
                    ])
                ])
            ]),
            new Any([
                'name' => 'Fixed Assets',
                'accounts' => $fixed_assets->map(function($item, $key){
                    return new Any([
                        'name' => $item->name,
                        'amount' => $item->currentAssetSummary->amount ?? 0
                    ]);
                })->reject(function($item){
                    return $item->amount == 0;
                })
            ])
        ]);

        $total_assets = ($assets[0]->accounts->sum('amount') + $assets[1]->accounts->sum('amount') + $assets[2]->accounts->sum('amount') + $assets[3]->accounts->sum('amount'));

        return view('admin.accounting.overview', compact('assets', 'expenses', 'revenue', 'monthlyExpenseSummary', 'total_assets','liabilities'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
