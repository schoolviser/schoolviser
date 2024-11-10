<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard.reports.index')->name('reports');

Route::get('/accounting/accounts-receivable', 'Report\AccountReceivableController@index')->name('reports.accounts.receivables');


