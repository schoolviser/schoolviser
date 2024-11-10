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

Route::group(['middleware' => ['auth:api']], function(){

    //Route::prefix('/account')->group(__DIR__.'/account.php');
    //Route::prefix('/users')->group(__DIR__.'/group/users.php');

});

Route::prefix('auth')->group(function(){
    //Route::post('/login', 'Auth\Api\LoginController@login');
    //Route::get('/logout', 'Auth\Api\LogoutController@logout')->middleware('auth:api');
});





