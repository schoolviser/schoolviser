<?php

use Illuminate\Support\Facades\Route;
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

 Route::get('/test', 'TestController')->name('test_home');



Route::middleware(['schoolviser.shield'])->group(function () {
    Auth::routes();
});

Route::group(['middleware' => ['auth','term', 'check.suspended']], function(){


 Route::get('/', 'DashboardController')->name('home');

 Route::get('/settings', 'Setting\SettingController')->middleware(['usertype:master|employee'])->name('settings');

 Route::get('/site-settings/terms', 'TermController@index')->middleware(['usertype:master'])->name('settings.terms');
 Route::post('/site-settings/terms/store', 'TermController@store')->middleware(['usertype:master'])->name('settings.terms.store');
 Route::get('/site-settings/terms/{id}', 'TermController@show')->middleware(['usertype:master'])->name('settings.terms.show');
 Route::post('/site-settings/terms/update/{id}', 'TermController@update')->middleware(['usertype:master'])->name('settings.terms.update');
 Route::get('/site-settings/terms/delete/{id}', 'TermController@destroy')->middleware(['usertype:master'])->name('settings.terms.delete');

 Route::get('/site-settings/classes', 'ClazzController@index')->middleware(['usertype:master'])->name('settings.clazzs');
 Route::post('/site-settings/classes/store', 'ClazzController@store')->middleware(['usertype:master'])->name('settings.clazzs.store');
 Route::post('/site-settings/classes/update/{id}', 'ClazzController@update')->middleware(['usertype:master'])->name('settings.clazzs.update');
 Route::get('/site-settings/classes/destroy/{id}', 'ClazzController@destroy')->middleware(['usertype:master'])->name('settings.clazzs.destroy');
 Route::get('/site-settings/classes/edit/{id}', 'ClazzController@edit')->middleware(['usertype:master'])->name('settings.clazzs.edit');



 Route::get('/site-settings', 'SiteSettingsController@index')->middleware(['usertype:master'])->name('site.settings');
 Route::get('/site-settings/school-info', 'SchoolInfoController@index')->middleware(['usertype:master'])->name('site.settings.school.info');
 Route::post('/site-settings/school-info/update', 'SchoolInfoController@update')->middleware(['usertype:master'])->name('site.settings.school.info.update');

 Route::get('/site-settings/subjects', 'SubjectController@index')->middleware(['usertype:master'])->name('site.settings.subjects');
 Route::get('/site-settings/subjects/show/{id}', 'SubjectController@show')->middleware(['usertype:master'])->name('site.settings.subjects.show');
 Route::get('/site-settings/subjects/edit/{id}', 'SubjectController@edit')->middleware(['usertype:master'])->name('site.settings.subjects.edit');
 Route::post('/site-settings/subjects/update/{id}', 'SubjectController@update')->middleware(['usertype:master'])->name('site.settings.subjects.update');
 Route::post('/site-settings/subjects/store', 'SubjectController@store')->middleware(['usertype:master'])->name('site.settings.subjects.store');


 Route::get('/site-settings/mtn-momo', 'MomoSettingsController@index')->middleware(['usertype:master'])->name('site.settings.mtn.momo');
 Route::post('/site-settings/mtn-momo/store', 'MomoSettingsController@storeSettings')->middleware(['usertype:master'])->name('site.settings.mtn.momo.store');
 Route::get('/site-settings/mtn-momo/generate-access-token', 'MomoSettingsController@generateAccesstoken')->middleware(['usertype:master'])->name('site.settings.mtn.momo.generate-token');

 Route::get('/site-settings/configure-course-groups', 'CourseGroupController@index')->middleware(['usertype:master'])->name('site.settings.course.groups');



});


Route::group(['middleware' => ['auth','usertype:master']], function(){
 Route::get('/init', 'Init\InitController')->name('init');
 Route::get('/set-up/set-periods', 'Init\SetTermController@index')->name('init.set.term');
 Route::post('/init/set/term', 'Init\SetTermController@store')->name('init.set.term.store');
 Route::post('/init/set/period', 'Init\SetTermController@storePeriod')->name('init.set.period.store');
});


Route::domain(env('APPLICATION_DOMAIN'))->group(function () {
 Route::get('/', function () {
  return "Coming Soon - Under development";
 });

});

Route::get('/vue', function () {
    return view('admin.indexvue');
})->name('vue.index');















