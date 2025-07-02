<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Login route using the traditional string syntax
Route::post('/login', 'Auth\Api\LoginController@login');


// Protected routes with 'auth:api' middleware
Route::middleware('auth:api')->group(function () {

    Route::get('/terms', 'Api\TermController@index')->middleware(['usertype:master'])->name('settings.terms');
    Route::get('/terms/current', 'Api\TermController@current')->middleware(['usertype:master'])->name('settings.terms');
    Route::post('/terms/store', 'Api\TermController@store')->middleware(['usertype:master'])->name('settings.terms');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });



});
