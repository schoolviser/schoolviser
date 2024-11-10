<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'User\UserController@index')->name('users')->middleware(['permissionViaSingleRole:can_view_user_listing']);

Route::get('/show/{id}', 'User\UserController@show')->name('users.show');
Route::get('/destroy/{id}', 'User\UserController@destroy')->name('users.destroy');
Route::get('/add', 'User\UserController@create')->name('users.create')->middleware(['permissionViaSingleRole:can_create_user_accounts']);
Route::post('/store', 'User\UserController@store')->name('users.store')->middleware(['permissionViaSingleRole:can_create_user_accounts']);

Route::post('/update/username/{id}', 'User\UserController@updateUsername')->name('users.update.username');

Route::post('/change/password/{id}', 'User\UserController@changePassword')->name('users.change.password');

Route::get('/roles', 'Role\RoleController@index')->name('roles')->middleware(['permissionViaSingleRole:can_manage_user_roles']);
Route::get('/roles/edit/{id}', 'Role\RoleController@edit')->name('roles.edit')->middleware(['permissionViaSingleRole:can_manage_user_roles']);
Route::post('/roles/update/{id}', 'Role\RoleController@update')->name('roles.update')->middleware(['permissionViaSingleRole:can_manage_user_roles']);
Route::post('/roles/store', 'Role\RoleController@store')->name('roles.store')->middleware(['permissionViaSingleRole:can_manage_user_roles']);
Route::get('/roles/destroy/{id}', 'Role\RoleController@destroy')->name('roles.destroy')->middleware(['permissionViaSingleRole:can_manage_user_roles']);


Route::get('/roles/permissions', 'Permission\PermissionController@index')->name('roles.permissions')->middleware(['permissionViaSingleRole:can_manage_system_permissions']);
Route::get('/roles/permissions/{permission_group_id}/{role_id}', 'Permission\PermissionController@show')->name('roles.permissions.show');
Route::post('/roles/permissions/setpermissions/{role_id}/{permission_group_id}', 'Permission\PermissionController@setPermissions')->name('roles.permissions.set.permissions');

Route::get('/authentication/logs', 'User\AuthenticationLogController@index')->name('users.authentication.logs')->middleware(['permissionViaSingleRole:can_view_user_listing']);

Route::get('/recently-active', 'User\LastSeenController')->name('users.recently.active')->middleware(['permissionViaSingleRole:can_view_user_listing']);


