<?php

use Illuminate\Support\Facades\Route;

Route::get('/registration', 'RegistrationController@index')->name('students.registration');
Route::get('/registration/register-new-student', 'RegistrationController@create')->name('students.registration.register');

Route::post('/registration/register/student', 'RegistrationController@regieterNew')->name('students.registration.register.process');

Route::get('/registration/register-old-student', 'RegistrationController@old')->name('students.registration.register.old');
Route::post('/registration/register-old-student/{id}', 'RegistrationController@regieterOld')->name('students.registration.register.old.process');

Route::get('/registration/registered-students', 'RegistrationController@registered')->name('students.registration.registered');


Route::get('/registrations/edit', 'RegistrationController@edit')->name('students.registrations.edit');
Route::post('/registrations/update', 'RegistrationController@update')->name('students.registrations.update');
Route::get('/registrations/show/{id}', 'RegistrationController@show')->name('students.registrations.show');
Route::get('/registrations/destroy/{id}', 'RegistrationController@show')->name('students.registrations.destroy');



Route::get('/year/{year}/term/{term}', 'StudentController@index')->name('students')->middleware(['permissionViaSingleRole:can_view_studets_listing']);
Route::get('//year/{year}/term/{term}/class/{class}', 'StudentController@indexOfClass')->name('students.class')->middleware(['permissionViaSingleRole:can_view_studets_listing']);
Route::post('/query', 'StudentController@query')->name('students.query')->middleware(['permissionViaSingleRole:can_view_studets_listing']);

Route::get('/viewbyyearterm/{year}/{term}/{class?}', 'StudentController@strudentsOfYearTerm')->name('students.viewbyYearTerm')->middleware(['permissionViaSingleRole:can_view_studets_listing']);

Route::post('/register', 'StudentController@store')->middleware(['permissionViaSingleRole:can_register_student']);


Route::post('/update/personalinfo/{id}', 'StudentController@updatePersonalInfo')->name('students.update.personalinfo')->middleware(['permissionViaSingleRole:can_update_students_personal_info']);
Route::post('/update/academicinfo/{id}', 'StudentController@updateAcademicInfo')->name('students.update.academicinfo')->middleware(['permissionViaSingleRole:can_update_students_registration_info']);



Route::post('/search', 'StudentController@of')->name('students.of');

Route::get('/year/{year}/term/{term}/clazz/{clazz}', 'StudentController@of')->name('students.of.clazz');

# Exporting students information
Route::get('export/{year}/{term}', 'StudentController@export')->name('students.export');

Route::get('import', 'Student\StudentImportController@index')->name('students.import');

Route::get('import/preview', 'Student\StudentImportController@preview')->name('students.import.preview');
Route::post('import/start', 'Student\StudentImportController@import')->name('students.import.import');






Route::get('/trash', 'StudentTrashController@index')->name('students.trash');
Route::get('/trash/restore/{id}', 'StudentTrashController@restore')->name('students.trash.restore');
Route::get('/trash/count', 'StudentTrashController@count')->name('students.trash.count');


Route::get('/archive/{id}', 'StudentController@archive')->name('students.archive');
Route::get('/archived', 'StudentController@archived')->name('students.archived');

//Termination
Route::post('/expel/student/{id}', 'StudentTerminationController@expel')->name('students.expel');

Route::get('/term/{term}/year/{year}', 'StudentController@index')->name('students.term.year');


Route::get('/groups', 'StudentGroupController@index')->name('students.groups');
Route::get('/groups/students/{id}', 'StudentGroupController@students')->name('students.groups.students');




Route::get('/parents', 'ParentController@index')->name('students.parents');
Route::post('/parents/{student_id?}', 'ParentController@store')->name('students.parents.add');
Route::get('/parents/show/{id}', 'ParentController@show')->name('students.parents.show');
Route::get('/parents/destroy/{id}', 'ParentController@destroy')->name('students.parents.destroy');



//Students payment records
Route::get('/fee-payment-record/{id}', 'Student\StudentFeePaymentRecordController@index')->name('students.fee.payment.record');


//Generate students reg numbers
Route::get('/generate/regnos/{id?}', 'Student\GenerateRegnoController')->name('students.generate.regno');

