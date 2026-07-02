<?php

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



Route::prefix('tertiary-students')->name('tertiary.students.')->middleware(['tertiary'])->group(function() {

    Route::get('/n/{intakeuuid?}', 'TertiaryStudentController@index')->name('index')->middleware(['company.role.permission:can_view_students_listing']);
    Route::get('/intake/{intakeuuid?}', 'TertiaryStudentController@index')->name('intake')->middleware(['company.role.permission:can_view_students_listing']);

    Route::get('/overview/{intakeuuid?}', 'TertiaryOverviewController@index')->name('overview')->middleware(['company.role.permission:can_view_students_listing']);
    Route::get('/gender-based/{gender}', 'TertiaryStudentController@getGenderBased')->name('gender.based')->middleware(['company.role.permission:can_view_students_listing']);
    Route::get('/per-course/{course_id}/{intake_id}', 'TertiaryStudentController@perCourse')->name('per.course')->middleware(['company.role.permission:can_view_students_listing']);
    Route::get('/search/{query?}', 'TertiaryStudentController@search')->name('search')->middleware(['company.role.permission:can_view_students_listing']);
    Route::get('/overview', 'TertiaryOverviewController@index')->name('overview');
    Route::get('/unregistered-students', 'TertiaryStudentController@unregistered')->name('unregistered');
    Route::post('/enroll/{student_id}', 'TertiaryStudentController@enroll')->name('enroll');
    Route::post('/build-enroll', 'TertiaryStudentController@bulkEnroll')->name('bulkEnroll');
    Route::get('/unenroll/{registration_id}', 'TertiaryStudentController@deregister')->name('unenroll');

    Route::get('/add-student', 'TertiaryStudentController@create')->name('create')->middleware(['company.role.permission:can_register_student']);
    Route::post('/add-student', 'TertiaryStudentController@store')->name('store')->middleware(['company.role.permission:can_register_student']);

    Route::get('/show/{id}', 'TertiaryStudentController@show')->name('show')->middleware(['company.role.permission:can_view_students_profile']);
    
    Route::get('/edit/{id}', 'TertiaryStudentController@edit')->name('edit');
    Route::get('/destroy/{id}', 'TertiaryStudentController@destroy')->name('delete')->middleware(['company.role.permission:can_delete_student_info']);

    Route::post('/update/personal-info/{id}', 'TertiaryStudentController@updatePersonalInfo')->name('updatePersonalInfo')->middleware(['company.role.permission:can_update_students_personal_info']);
    
    Route::post('/update/reg-info/{studentId}/{intakeRegistrationId}', 'TertiaryStudentController@updateAcademicInfo')->name('updateAcademicInfo')->middleware(['company.role.permission:can_update_students_registration_info']);

    Route::post('/profile/update/photo/{id}', 'TertiaryStudentController@updatePhoto')->name('updatePhoto')->middleware(['company.role.permission:can_update_students_photo']);

    Route::get('/export/{intakeid?}', 'TertiaryStudentController@export')->name('export');
    Route::post('/selected-students-export', 'TertiaryStudentController@selectedStudentsExport')->name('selectedStudentsExport');

    Route::get('import', function(){
        return 'import students';
    })->name('students.import');

});

Route::prefix('tertiary')->name('tertiary.')->middleware(['tertiary'])->group(function() {

    Route::prefix('intake-registtrations')->name('intake.registrations.')->group(function() {
        Route::get('/m/{intakeid?}', 'IntakeRegistrationController@index')->name('index')->middleware(['company.role.permission:can_view_student_registrations']);
        Route::post('/lock-registration/{id}', 'IntakeRegistrationController@lockRegistration')->name('lock')->middleware(['company.role.permission:can_lock_student_registration']);
        Route::post('/unlock-registration/{id}', 'IntakeRegistrationController@unLockRegistration')->name('unlock')->middleware(['company.role.permission:can_unlock_student_registration']);
    });

});

Route::get('/settings/year-groups', 'YearGroupController@index')->name('settings.year.groups');
Route::get('/settings/year-groups/create-new', 'YearGroupController@create')->name('settings.year.groups.create');
Route::post('/settings/year-groups/create-new', 'YearGroupController@store')->name('settings.year.groups.store');
Route::get('/settings/year-groups/edit/{id}', 'YearGroupController@edit')->name('settings.year.groups.edit');
Route::post('/settings/year-groups/update/{id}', 'YearGroupController@update')->name('settings.year.groups.update');

