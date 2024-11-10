<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'Department\DepartmentController@index')->name('departments');
Route::post('/store', 'Department\DepartmentController@store')->name('departments.store');
Route::post('/update/{id}', 'Department\DepartmentController@update')->name('departments.update');
Route::get('/destroy/{id}', 'Department\DepartmentController@destroy')->name('departments.destroy');