<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Inventory\InventoryController')->name('inventory');

Route::get('/products', 'Inventory\InventoryItemController@index')->name('inventory.items');
Route::post('/items/store', 'Inventory\InventoryItemController@store')->name('inventory.items.store');
Route::get('/items/destroy/{id}', 'Inventory\InventoryItemController@destroy')->name('inventory.items.delete');

Route::get('/products/stockins', 'Inventory\InventoryStockInController@index')->name('inventory.items.stockins');

