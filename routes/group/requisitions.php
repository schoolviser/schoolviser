<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Requisition\RequisitionController@index')->name('requisitions');
Route::view('/show', 'requisitions.show')->name('requisitions.show');


Route::view('/purchase-requisition/create', 'requisitions.create')->name('requisitions.purchase.create');