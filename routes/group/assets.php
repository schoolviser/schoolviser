<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'AssetController@index')->name('assets')->middleware(['permissionViaSingleRole:can_view_assets']);

Route::get('/overview', 'Asset\AssetOverviewController')->name('assets.overview');

Route::get('/add', 'AssetController@create')->name('assets.add')->middleware(['permissionViaSingleRole:can_add_asset']);
Route::post('/store', 'AssetController@store')->name('assets.store')->middleware(['permissionViaSingleRole:can_add_asset']);

Route::get('/show/{id}', 'AssetController@show')->name('assets.show')->middleware(['permissionViaSingleRole:can_view_asset_details']);
Route::get('/destroy/{id}', 'AssetController@destroy')->name('assets.destroy')->middleware(['permissionViaSingleRole:can_delete_asset']);

Route::get('/edit/{id}', 'AssetController@edit')->name('assets.edit')->middleware(['permissionViaSingleRole:can_edit_asset_details']);
Route::post('/update/{id}', 'AssetController@update')->name('assets.update')->middleware(['permissionViaSingleRole:can_edit_asset_details']);
Route::post('/update/finance/{id}', 'AssetController@updateFinance')->name('assets.update.finance')->middleware(['permissionViaSingleRole:can_edit_asset_finance_details']);

Route::post('/update/photo/{id}', 'AssetController@updatePhoto')->name('assets.update.photo')->middleware(['permissionViaSingleRole:can_change_asset_photo']);

//asset deprecition details
Route::get('/show/depreciation/schedule/{id}', 'Asset\DepreciationScheduleController@index')->name('assets.show.depreciation.schedule');
Route::get('/show/depreciation/schedule/run/{id}', 'Asset\DepreciationScheduleController@index')->name('assets.show.depreciation.schedule.run');


//Asset types
Route::get('/asset-types', 'Asset\AssetTypeController@index')->name('assets.types')->middleware(['permissionViaSingleRole:can_view_asset_types']);

Route::get('/asset-types/items/{id}', 'Asset\AssetTypeController@items')->name('assets.types.items');

Route::get('/asset-types/destroy/{id}', 'Asset\AssetTypeController@destroy')->name('assets.types.destroy');

Route::get('/asset-status/destroy/{id}', 'Asset\AssetStatusController@destroy')->name('assets.status.destroy');
Route::post('/asset-status/store', 'Asset\AssetStatusController@store')->name('assets.status.store');

Route::post('/checkout/{id}', 'Asset\AssetCheckOutController@checkout')->name('assets.checkout');

Route::post('/checkin/{id}', 'Asset\AssetCheckInController@checkin')->name('assets.checkin');





Route::get('/categories', 'AssetCategoryController@index')->name('assets.categories');
Route::get('/categories/show/{id}', 'AssetCategoryController@show')->name('assets.categories.show');
Route::get('/categories/destroy/{id}', 'AssetCategoryController@destroy')->name('assets.categories.destroy');

Route::get('/dispose/{id}', 'AssetController@dispose')->name('assets.dispose');
Route::get('/undispose/{id}', 'AssetController@undispose')->name('assets.undispose');
Route::get('/disposed', 'AssetController@disposed')->name('assets.disposed');


Route::get('/import', 'Asset\AssetImportController@index')->name('assets.import');
Route::post('/import', 'Asset\AssetImportController@import')->name('assets.import.store');
Route::get('/import/downlaod/template', 'Asset\AssetImportController@downloadTemplate')->name('assets.import.download.template');


Route::get('/export', 'AssetController@export')->name('assets.export')->middleware(['permissionViaSingleRole:can_edit_asset_details']);



