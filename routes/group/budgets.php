<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Budget\BudgetController@index')->name('accounting.budgets');

Route::post('/expense/projections/store/{budget_id}', 'Budget\ExpenseProjectionController@store')->name('accounting.budgets.expense.projections.store');




