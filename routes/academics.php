<?php

use Illuminate\Support\Facades\Route;


Route::get('/timetable', 'Academics\TimeTableController@index')->name('academics.timetable');

Route::post('/timetable/routine/store', 'Academics\TimeTableController@store')->name('academics.timetable.routine.store');
Route::get('/timetable/show/{id}', 'Academics\TimeTableController@show')->name('academics.timetable.show');


Route::get('/subjects', 'Academics\SubjectController@index')->name('academics.subjects');
Route::post('/subjects/store', 'Academics\SubjectController@store')->name('academics.subjects.store');
Route::get('/subjects/show/{id}', 'Academics\SubjectController@show')->name('academics.subjects.show');
Route::get('/subjects/destroy/{id}', 'Academics\SubjectController@destroy')->name('academics.subjects.destroy');
















