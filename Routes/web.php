<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

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

Route::prefix(config('delxero.dashboard_prefix', '/'))->middleware(['invalidate.session', 'otp.verified','ensure.company','user.company.subscribed'])->group(function(){

    // Secondary Students
    require __DIR__.'/web/secondary.php';
    require __DIR__.'/web/tertiary.php';

    // Settings
    Route::prefix(config('schoolviser.settings_route_prefix', 'settings'))->group(function(){

        # Ademics Settings
        Route::prefix('academics')->group(function(){
             Route::prefix('subjects')->name('subjects.')->group(function(){
                Route::get('/', 'Academics\SubjectController@index')->name('index');
                Route::get('/show/{id}', 'Academics\SubjectController@show')->name('show');
            });
        });

        # Academic Year Routes
        Route::prefix('manage-academic-years')->name('manageacademicyears.')->group(function(){
            Route::get('/', 'AcademicYearController@index')->name('index');
            Route::post('/store', 'AcademicYearController@store')->name('store');
            Route::get('/show-details/{id}', 'AcademicYearController@show')->name('show');
            Route::post('/update/{id}', 'AcademicYearController@update')->name('update');
            Route::get('/delete/{id}', 'AcademicYearController@destroy')->name('delete');
        });

        # Term Routes
        Route::prefix('manage-terms')->name('manageterms.')->group(function(){
            Route::get('/', 'TermController@index')->name('index');
            Route::get('/current-year-terms', 'TermController@currentYearTermsMinimal')->name('currentYearTermsMinimal');
            Route::post('/store', 'TermController@store')->name('store');
            Route::get('/show-details/{id}', 'TermController@show')->name('show');
            Route::get('/edit-term/{id}', 'TermController@edit')->name('edit');
            Route::post('/update/{id}', 'TermController@update')->name('update');
            Route::get('/delete/{id}', 'TermController@destroy')->name('delete');
        });

        Route::prefix('term-translations')->name('term.translations.')->group(function(){
            Route::get('/{locale}', 'TermTranslationController@index')->name('index');
            Route::post('/{locale}', 'TermTranslationController@store');
        });

        Route::prefix('manage-classes')->name('manageclazzs.')->group(function(){
            Route::get('/', 'ClazzController@index')->name('index');
            Route::post('/store', 'ClazzController@store')->name('store');
            Route::post('/update/{id}', 'ClazzController@update')->name('update');
            Route::get('/destroy/{id}', 'ClazzController@destroy')->name('destroy');
            Route::get('/edit/{id}', 'ClazzController@edit')->name('edit');
        });

        Route::prefix('manage-courses')->name('managecourses.')->group(function(){
            
            Route::get('/', 'CourseController@index')->name('index');
            Route::get('/create', 'CourseController@create')->name('create');
            Route::post('/store', 'CourseController@store')->name('store');
            Route::get('/edit/{id}', 'CourseController@edit')->name('edit');
            Route::post('/update/{uuid}', 'CourseController@update')->name('update');
            Route::get('/destroy/{id}', 'CourseController@destroy')->name('destroy');
            Route::get('/all-courses-minimal', 'CourseController@allCoursesMinimal')->name('allCoursesMinimal');

            Route::prefix('cohorts')->name('cohorts.')->group(function () {
                Route::get('/', 'CohortController@index')->name('index');
                Route::get('/create', 'CohortController@create')->name('create');
                Route::post('/store', 'CohortController@store')->name('store');
                Route::get('/show/{id}', 'CohortController@show')->name('show');
                Route::get('/edit/{id}', 'CohortController@edit')->name('edit');
                Route::post('/update/{id}', 'CohortController@update')->name('update');
                Route::get('/destroy/{id}', 'CohortController@destroy')->name('destroy');
            });

            Route::prefix('course-groups')->name('coursegroups.')->group(function () {
                Route::get('/', 'CourseGroupController@index')->name('index');
                Route::post('/update/{id}', 'CourseGroupController@update')->name('update');
                Route::post('/store', 'CourseGroupController@store')->name('store');
            });

        });

        Route::prefix('subjects')->name('subjects.')->group(function(){
            Route::get('/', 'Academics\SubjectController@index')->name('index');
        });

        Route::get('schoolviser-setup', 'SchoolviserSetupController@index')->name('schoolviser.setup');
        Route::post('schoolviser-setup', 'SchoolviserSetupController@setup');

        Route::prefix('mkt')->name('mkt.')->group(function() {
            Route::get('/', 'DelxeroMktSettingControlerController@index')->name('index');
            Route::post('/set', 'DelxeroMktSettingControlerController@store')->name('set');
        });
        

    });

    // Analyticals
    Route::prefix('analytics')->name('analytics.')->group(function(){
        Route::prefix('tertiary')->name('tertiary.')->group(function() {
            Route::get('/course-enrollment-trend/{academicYearUuid}', 'CourseEnrollmentTrendController@enrollmentTrend')->name('course-enrollment-trend');
        });
    });

});























