<?php

use Illuminate\Support\Facades\Route;

use App\Hostel;

Route::get('/', 'HostelController@index')->name('hostels');
Route::get('/create', 'HostelController@create')->name('hostels.create');
Route::get('/store', 'HostelController@store')->name('hostels.store');
Route::get('/show/{id}', 'HostelController@show')->name('hostels.show');
Route::get('/edit/{id}', 'HostelController@edit')->name('hostels.edit');
Route::get('/update/{id}', 'HostelController@update')->name('hostels.update');
Route::get('/delete/{id}', 'HostelController@destroy')->name('hostels.destroy');

Route::get('/add/students/{id}', 'HostelController@addStudent')->name('hostels.add.students');
Route::get('/add/student/{id}/{student_id}', 'HostelController@addStudent')->name('hostels.add.student');
Route::get('/remove/student/{id}/{student_id}', 'HostelController@removeStudent')->name('hostels.remove.student');

Route::post('/allocate/{termly_registration_id}', 'AllocateHostelController@allocate')->name('hostels.allocate');


Route::get('/students', 'HostelStudentController@index')->name('hostels.students');



