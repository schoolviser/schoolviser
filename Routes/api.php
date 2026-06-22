<?php

use Illuminate\Http\Request;

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

Route::prefix('students')->group(function() {
    if (config('schoolviser.type') == 'tertiary') {
        Route::get('/', 'Api\TertiaryStudentController@index')->name('students')->middleware(['role.permission:can_view_studets_listing']);
        Route::get('/overview', 'Api\TertiaryOverviewController@index')->name('students.overview');
        Route::get('/show/{id}', 'Api\TertiaryStudentController@show')->name('students.show')->middleware(['role.permission:can_view_individual_students_info']);
        Route::get('/gender-based/{gender}', 'Api\TertiaryStudentController@getGenderBased')->name('students.gender.based')->middleware(['role.permission:can_view_studets_listing']);
        Route::get('/search/{query?}', 'Api\TertiaryStudentController@search')->name('students.search')->middleware(['role.permission:can_view_studets_listing']);


        Route::get('/per-course/{course_id}/{intake_id}', 'TertiaryStudentController@perCourse')->name('students.per.course')->middleware(['role.permission:can_view_studets_listing']);
        Route::get('/unregistered-students', 'TertiaryStudentController@unregistered')->name('students.unregistered');
        Route::post('/enroll/{student_id}', 'TertiaryStudentController@enroll')->name('students.enroll');


        Route::post('/add-student', 'TertiaryStudentController@store')->name('students.store')->middleware(['role.permission:can_register_student']);

        Route::get('/edit/{id}', 'TertiaryStudentController@edit')->name('students.edit');
        Route::get('/destroy/{id}', 'TertiaryStudentController@destroy')->name('students.delete')->middleware(['role.permission:can_delete_student_info']);

        Route::post('/update/personal-info/{id}', 'TertiaryStudentController@updatePersonalInfo')->name('students.update.personal.info')->middleware(['role.permission:can_update_students_personal_info']);;
        Route::post('/update/reg-info/{id}', 'TertiaryStudentController@updateAcademicInfo')->name('students.update.reg.info')->middleware(['role.permission:can_update_students_registration_info']);

        Route::post('/profile/update/photo/{id}', 'StudentController@updatePhoto')->name('students.update.photo')->middleware(['role.permission:can_update_students_photo']);

        Route::get('import', function(){
            return 'import students';
        })->name('students.import');

    } else {
        Route::get('/overview', 'OverviewController@index')->name('students.overview');
        Route::get('/', 'StudentController@index')->name('students');
        Route::get('/add-student', 'StudentController@create')->name('students.create');
        Route::post('/store', 'StudentController@store')->name('students.store');

        Route::get('/show/{id}', 'StudentController@show')->name('students.profile')->middleware(['role.permission:can_view_individual_students_info']);
        Route::get('/edit/{id}', 'StudentController@edit')->name('students.edit');
        Route::post('/update/personal-info/{id}', 'StudentController@updatePersonalInfo')->name('students.update.personal.info')->middleware(['role.permission:can_update_students_personal_info']);

        //Students By Clazz
        Route::get('/clazz/{id}', 'ClazzStudentController@index')->name('students.clazz');
        Route::get('/clazz/{id}/search/{query}', 'ClazzStudentController@search')->name('students.clazz.search');



        Route::get('/destroy/{id}', 'StudentController@destroy')->name('students.delete')->middleware(['permission:can_delete_student_info']);
        Route::get('/destroy/permanently/{id}', 'StudentTrashController@destroyPermanently')->name('students.delete.permanently');

        Route::post('/profile/update/photo/{id}', 'StudentController@updatePhoto')->name('students.update.photo')->middleware(['role.permission:can_update_students_personal_info']);
        Route::get('/study/history/{id}', 'StudentController@studyHistory')->name('students.study.history');

        Route::get('/unregistered-students', 'StudentController@unregistered')->name('students.unregistered');

         Route::get('import', function(){
            return 'import students';
        })->name('students.import');


    }

});
