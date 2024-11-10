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

Route::get('/terms', 'TermController@index')->name('terms');
Route::get('/terms/show/{id}', 'TermController@show')->name('terms.show');

Route::post('/terms/store', 'TermController@store')->name('terms.store');
Route::post('/terms/update/{id}', 'TermController@update')->name('terms.update');

















