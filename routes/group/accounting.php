<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Accounting\AccountingController@index')->name('accounting');

Route::get('/overview', 'Accounting\AccountingController@overview')->name('accounting.overview')->middleware('permissionViaSingleRole:can_access_accounting_overview');


Route::get('/expenses/termly', 'Accounting\TermlyExpenseController@index')->name('accounting.expenses.termly')->middleware(['permissionViaSingleRole:can_view_expenses']);

Route::get('/payments', 'Accounting\ExpenseTransactionController@index')->name('accounting.expenses')->middleware(['permissionViaSingleRole:can_view_expenses']);
Route::post('/expenses/record/store', 'Accounting\ExpenseTransactionController@store')->name('accounting.expenses.record.store')->middleware(['permissionViaSingleRole:can_record_expenses']);
Route::get('/expenses/edit/{id}', 'Accounting\ExpenseTransactionController@edit')->name('accounting.expenses.edit')->middleware(['permissionViaSingleRole:can_edit_expense']);
Route::post('/expenses/update/{id}', 'Accounting\ExpenseTransactionController@update')->name('accounting.expenses.update')->middleware(['permissionViaSingleRole:can_update_expense']);

Route::post('/expenses/item/update/{id}', 'Accounting\ExpenseItemController@update')->name('accounting.expenses.item.update')->middleware(['permissionViaSingleRole:can_update_expense']);
Route::get('/expense/item/destroy/{id}', 'Accounting\ExpenseItemController@destroy')->name('accounting.expenses.item.destroy');

Route::get('/previous-term-expense-transactions', 'Accounting\ExpenseTransactionController@getPreviousTermExpenseTransactions')->name('accounting.expenses.previous.term')->middleware(['permissionViaSingleRole:can_view_expenses']);

//Printing

Route::get('/payment/print-payment/{id}', 'Accounting\PrintPaymentController')->name('accounting.payment.print')->middleware(['permissionViaSingleRole:can_view_expenses']);

Route::get('/payments/report', 'Accounting\PaymentReportController@index')->name('accounting.payments.report');
Route::post('/payments/report/get', 'Accounting\PaymentReportController@get')->name('accounting.payments.report.get');
Route::get('/payments/report/{start_date?}/{end_date?}', 'Accounting\PaymentReportController@show')->name('accounting.payments.report.show');
Route::get('/payments/report/pdf/{start_date?}/{end_date?}', 'Accounting\PaymentReportController@downLoadPdf')->name('accounting.payments.report.pdf');


Route::get('/expenses/expense-categories/destroy/{id}', 'Accounting\ExpenseCategoryController@destroy')->name('accounting.expenses.categories.destroy');
Route::post('/expenses/expense-categories/store/{parent_id?}', 'Accounting\ExpenseCategoryController@store')->name('accounting.expenses.categories.store');
Route::post('/expenses', 'Accounting\ExpenseController@find')->name('accounting.expenses.find');

# Monthly Expenses
Route::get('/expenses/monthly-expenses', 'Accounting\MonthlyExpenseController@index')->name('accounting.expenses.monthly');



Route::prefix('/requisitions')->group(__DIR__.'/requisitions.php');


Route::get('/bills', 'Accounting\BillController@index')->name('accounting.bills');
Route::get('/record-bill', 'Accounting\BillController@create')->name('accounting.bills.create');
Route::post('/bills/store', 'Accounting\BillController@store')->name('accounting.bills.store');
Route::post('/pay-bill/{id}', 'Accounting\BillController@pay')->name('accounting.bills.pay');


Route::get('/bills/awaiting-payment', 'Bill\AwaitingPaymentBillController')->name('accounting.bills.awaiting.payment');


Route::get('/vendors', 'Vendors\VendorController@index')->name('accounting.vendors');
Route::post('/vendors/store', 'Vendors\VendorController@store')->name('accounting.vendors.add');

Route::get('/vendors/show/{id}', 'Vendors\VendorController@show')->name('accounting.vendors.show');



//Budgeting
Route::prefix('/budgeting')->group(__DIR__.'/budgeting.php');

Route::prefix('/vendors')->group(__DIR__.'/vendors.php');


Route::get('/revenue', 'Accounting\Coa\RevenueController@index')->name('accounting.revenue');
Route::post('/revenue/store', 'Accounting\Coa\RevenueController@store')->name('accounting.revenue.store');
Route::get('/revenue/delete/{id}', 'Accounting\Coa\RevenueController@destroy')->name('accounting.revenue.delete');

Route::get('/expenses/summary/{id?}', 'Accounting\ExpenseSummaryController@index');



/**
 * Income, IncomeSources, IncomeCollection
 */
Route::get('/revenue/other-income', 'Accounting\IncomeController@index')->name('accounting.incomes')->middleware('permissionViaSingleRole:can_view_revenue');
Route::get('/revenue/other-income/create', 'Accounting\IncomeController@create')->name('accounting.incomes.create');
Route::post('/revenue/other-income/store', 'Accounting\IncomeController@store')->name('accounting.incomes.store')->middleware('permissionViaSingleRole:can_add_income');
Route::post('/revenue/other-income/update/{id}', 'Accounting\IncomeController@update')->name('accounting.incomes.update');
Route::get('/revenue/other-income/destroy/{id}', 'Accounting\IncomeController@destroy')->name('accountingincomes.destroy');

Route::get('/revenue/fee-payment-transactions', 'Fee\FeePaymentTransactionController@index')->name('accounting.fee.payment.transactions')->middleware('permissionViaSingleRole:can_view_revenue');




//Chart Of Accounts Routes

Route::post('/chart-of-acconts/revenue/store', 'Accounting\Coa\RevenueAccountController@store')->name('accounting.coas.revenue.store');
Route::post('/chart-of-acconts/revenue/update/{id}', 'Accounting\Coa\RevenueAccountController@update')->name('accounting.coas.revenue.update')->middleware('permissionViaSingleRole:can_edit_chart_of_accounts');
Route::get('/chart-of-acconts/revenue/destroy/{id}', 'Accounting\Coa\RevenueAccountController@destroy')->name('accounting.coas.revenue.destroy')->middleware('permissionViaSingleRole:can_delete_chart_of_accounts');



Route::post('/chart-of-acconts/banks/update/{id}', 'Accounting\Coa\BankAccountController@update')->name('accounting.coas.banks.update');




Route::get('/banks/deposits/destroy/{id}', 'Accounting\Bank\BankDepositController@destroy')->name('accounting.banks.deposits.destroy');
Route::post('/banks/deposits/store/{bank_id}', 'Accounting\Bank\BankDepositController@store')->name('accounting.banks.deposits.add');


Route::get('/banks/withdrawals/{bank_id}', 'Accounting\Bank\BankWithdrawalController@index')->name('accounting.banks.withdrawals');
Route::post('/banks/withdrawals/store/{bank_id}', 'Accounting\Bank\BankWithdrawalController@store')->name('accounting.banks.withdrawals.withdraw');



Route::get('/banks/transactions/{bank_id}', 'Accounting\Bank\BankTransactionController@index')->name('accounting.banks.transactions');
Route::post('/banks/transactions/transfer/money/{from_id}', 'Accounting\Bank\BankTransactionController@transferMoney')->name('accounting.banks.transactions.transfer.money');




Route::get('/cash-book', 'Accounting\CashBookController@index')->name('accounting.cash.book');

Route::post('/cash-book/add/money/{account_id}', 'Accounting\CashBookController@addMoney')->name('accounting.cash.book.add.money');

Route::get('/cash-book/accountability-for-deposit/{account_id}/{deposit_id}', 'Accounting\CashDepositAccountabilityController')->name('accounting.cash.book.deposit.accountability');














