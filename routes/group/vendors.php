<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Vendors\VendorController@index')->name('accounting.vendors');
Route::get('/delete/{id}', 'Vendors\VendorController@destroy')->name('accounting.vendors.delete');


Route::get('/all-without-relations', 'Vendors\VendorController@vendorsWithoutRelations')->name('accounting.vendors.without.relations');



