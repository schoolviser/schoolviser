<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Staff\StaffController@index')->name('staff')->middleware(['permissionViaSingleRole:can_view_employee_listing']);
Route::get('/add', 'Staff\StaffController@create')->name('staff.add')->middleware(['permissionViaSingleRole:can_add_emloyee']);
Route::post('/add/store', 'Staff\StaffController@store')->name('staff.store')->middleware(['permissionViaSingleRole:can_add_emloyee']);

Route::get('/show/{id}', 'Staff\StaffController@show')->name('staff.show')->middleware(['permissionViaSingleRole:can_view_staff_profile']);
Route::get('/destroy/{id}', 'Staff\StaffController@destroy')->name('staff.destroy')->middleware(['permissionViaSingleRole:can_delete_employee_details']);

Route::post('/update/photo/{id}', 'Staff\StaffController@updatePhoto')->name('staff.update.photo')->middleware(['permissionViaSingleRole:can_delete_employee_details']);
Route::post('/update/personal/info/{id}', 'Staff\StaffController@updatePersonalInfo')->name('staff.update.personal.info');
Route::post('/update/work/info/{id}', 'Staff\StaffController@updateWorkInfo')->name('staff.update.work.info');

Route::get('/trash', 'Staff\StaffController@trash')->name('staff.trash')->middleware(['permissionViaSingleRole:can_view_employee_trash']);
Route::get('/trash/restore/{id}', 'Staff\StaffController@restore')->name('staff.trash.restore')->middleware(['permissionViaSingleRole:can_restore_employee_from_trash']);

Route::get('/left', 'Staff\StaffController@left')->name('staff.left')->middleware(['permissionViaSingleRole:can_view_employee_trash']);

Route::post('/left/mark-as-left/{id}', 'Staff\StaffController@markAsLeft')->name('staff.mark.as.left');
Route::get('/left/unmark-as-left/{id}', 'Staff\StaffController@unMarkAsLeft')->name('staff.unmark.as.left');



Route::post('/create/user/account/{id}', 'Staff\StaffController@createUserAccount')->name('staff.createUserAccount');

Route::get('/positions', 'Staff\StaffPositionController@index')->name('staff.positions')->middleware(['permissionViaSingleRole:can_view_employee_positions_listing']);
Route::post('/positions/store', 'Staff\StaffPositionController@store')->name('staff.positions.store')->middleware(['permissionViaSingleRole:can_create_or_add_employee_positions']);
Route::post('/positions/update/{id}', 'Staff\StaffPositionController@update')->name('staff.positions.update')->middleware(['permissionViaSingleRole:can_update_employee_positions']);
Route::get('/positions/destroy/{id}', 'Staff\StaffPositionController@destroy')->name('staff.positions.destroy')->middleware(['permissionViaSingleRole:can_delete_employee_positions']);


Route::get('/import', 'Staff\StaffController@import')->name('staff.import');
Route::post('/import', 'Staff\StaffController@import')->name('staff.import.process');






