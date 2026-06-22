<?php

Route::prefix('students')->name('students.')->group(function() {
    
    Route::get('/overview', 'OverviewController@index')->name('overview');

    Route::get('/', 'StudentController@index')->name('index')->middleware(['company.role.permission:can_view_students_listing']);

    Route::get('/add-student', 'StudentController@create')->name('create')->middleware(['company.role.permission:can_register_student']);
    Route::post('/store', 'StudentController@store')->name('store')->middleware(['company.role.permission:can_register_student']);

    Route::get('/students-profile/{id}', 'StudentController@show')->name('profile')->middleware(['company.role.permission:can_view_students_profile']);
    Route::get('/edit/{id}', 'StudentController@show')->name('edit')->middleware(['company.role.permission:can_view_students_profile']);
    Route::post('/update/personal-info/{id}', 'StudentController@updatePersonalInfo')->name('updatePersonalInfo')->middleware(['company.role.permission:can_update_students_personal_info']);
    Route::post('/update/academic-info/{termly_registration_id}', 'StudentController@updateAcademicInfo')->name('updateAcademicInfo')->middleware(['company.role.permission:can_update_students_registration_info']);

    Route::post('/lock-registration/{termly_registration_id}', 'StudentController@lockRegistration')->name('lock.registration')->middleware(['company.role.permission:can_lock_student_registration']);
    Route::post('/unlock-registration/{termly_registration_id}', 'StudentController@unlockRegistration')->name('unlock.registration')->middleware(['company.role.permission:can_unlock_student_registration']);

    //Students By Clazz
    Route::get('/clazz/{id}', 'ClazzStudentController@index')->name('clazz');
    Route::get('/clazz/{id}/search/{query}', 'ClazzStudentController@search')->name('clazz.search');

    Route::get('/destroy/{id}', 'StudentController@destroy')->name('students.delete')->middleware(['company.role.permission:can_delete_student_info']);
    Route::get('/destroy/permanently/{id}', 'StudentTrashController@destroyPermanently')->name('students.delete.permanently');

    Route::post('/profile/update/photo/{id}', 'StudentController@updatePhoto')->name('update.photo')->middleware(['company.role.permission:can_update_students_personal_info']);
    Route::get('/study/history/{id}', 'StudentController@studyHistory')->name('study.history');

    Route::get('/unregistered-students', 'StudentController@unregistered')->name('unregistered');

    Route::get('/gender-based/{gender}', 'StudentController@getGenderBased')->name('gender.based')->middleware(['company.role.permission:can_view_studets_listing']);


    Route::get('import', function(){
        return 'import students';
    })->name('students.import');
});
