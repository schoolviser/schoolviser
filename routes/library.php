<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'Library\LibraryController@index')->name('library');

Route::get('/items', 'Library\ItemController@index')->name('library.items');
Route::get('/items/create', 'Library\ItemController@create')->name('library.items.create');
Route::post('/items/store', 'Library\ItemController@store')->name('library.items.store');
Route::get('/items/show/{id}', 'Library\ItemController@show')->name('library.items.show');
Route::get('/items/edit/{id}', 'Library\ItemController@edit')->name('library.items.edit');
Route::post('/items/update/{id}', 'Library\ItemController@update')->name('library.items.update');
Route::get('/items/destroy/{id}', 'Library\ItemController@destroy')->name('library.items.destroy');


Route::get('/items/copies/{item_id}', 'Library\ItemCopyController@index')->name('library.items.copies');
Route::post('/items/copies/store/{item_id}', 'Library\ItemCopyController@store')->name('library.items.copies.store');
Route::get('/items/copies/show/{id}', 'Library\ItemCopyController@show')->name('library.items.copies.show');
Route::get('/items/copies/edit/{id}', 'Library\ItemCopyController@edit')->name('library.items.copies.edit');
Route::post('/items/copies/update/{id}', 'Library\ItemCopyController@update')->name('library.items.copies.update');
Route::get('/items/copies/destroy/{id}', 'Library\ItemCopyController@destroy')->name('library.items.copies.destroy');


Route::get('/members', 'Library\LibraryMemberController@index')->name('library.members');
Route::get('/members/blocked', 'Library\LibraryMemberController@blocked')->name('library.members.blocked');

Route::get('/members/register/student', 'Library\RegisterStudentMemberController@index')->name('library.members.register.student');
Route::post('/members/register/student/{id}', 'Library\RegisterStudentMemberController@register')->name('library.members.register.student.process');


Route::get('/items/books', 'Library\BookController@index')->name('library.items.books');
Route::post('/items/books/store', 'Library\BookController@store')->name('library.items.books.store');
Route::get('/items/books/show/{id}', 'Library\BookController@show')->name('library.items.books.show');


Route::get('/circulation/checkouts', 'Library\CheckOutController@index')->name('library.items.checkouts');

Route::get('/items/checkins', 'Library\CheckInController@index')->name('library.items.checkins');

Route::get('/publishers', 'Library\PublisherController@index')->name('library.publishers');

