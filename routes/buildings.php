<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Building\BuildingController@index')->name('buildings');
Route::post('/store', 'Building\BuildingController@store')->name('buildings.store');

Route::get('/rooms', 'Building\RoomController@index')->name('rooms');
Route::get('/rooms/destroy/{id}', 'Building\RoomController@destroy')->name('rooms.destroy');
Route::post('/rooms/store', 'Building\RoomController@store')->name('rooms.store');
Route::post('/rooms/update/{id}', 'Building\RoomController@update')->name('rooms.update');










