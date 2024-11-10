<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Accounting\Budgeting\BudgetingController')->name('accounting.budgeting');
Route::get('/expense-projection', 'Accounting\Budgeting\ExpenseProjectionController@index')->name('accounting.budgeting.expense.projections');

Route::get('/expense-projections', 'Accounting\Budgeting\ExpenseProjectionController@index')->name('accounting.budgeting.expenses.projections');
Route::post('/expense-projections/store', 'Accounting\Budgeting\ExpenseProjectionController@store')->name('accounting.budgeting.expenses.projections.store');

Route::get('/expense-projection/destroy/{id}', 'Accounting\Budgeting\ExpenseProjectionController@destroy')->name('accounting.budgeting.expense.projection.destroy');





