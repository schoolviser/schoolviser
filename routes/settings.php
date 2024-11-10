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

Route::group(['middleware' => ['permissionViaSingleRole:can_view_system_settings']], function(){
 
 # Hostels
 Route::prefix('/hostels')->group(__DIR__.'/hostels.php');

 # Buildings
 Route::prefix('/buildings')->group(__DIR__.'/buildings.php');

 # DEpartments
 Route::prefix('/departments')->group(__DIR__.'/group/departments.php');


 Route::get('/payroll/overview', 'PayRoll\PayRollController@overview')->name('payroll.overview');
 Route::get('/payroll/payrolls', 'PayRoll\PayRollController@index')->name('payroll.payrolls');

 Route::get('/payroll/payrolls/show/{id}', 'PayRoll\PayRollController@show')->name('payroll.payrolls.show');




 Route::view('/', 'dashboard.settings.index')->name('settings')->middleware(['auth','usertype:employee|master']);

 Route::get('/general/current/term', 'Settings\TermController@index')->name('settings.current.term');
 Route::post('/general/current/term/update', 'Settings\TermController@update')->name('settings.current.term.update');


 Route::get('/general/school-info', 'GeneralSettingController@index')->name('settings.school.info');
 Route::post('/general/school-info', 'GeneralSettingController@update')->name('settings.school.info.update');
 
 Route::post('/general/update', 'GeneralSettingController@update')->name('settings.general.update');


 Route::get('/students/registraion', 'Settings\StudentRegistrationSettingsController@index')->name('settings.students.registration');
 Route::post('/students/registraion/update', 'Settings\StudentRegistrationSettingsController@update')->name('settings.students.registration.update');

 Route::get('/students/general', 'Settings\StudentGeneralSettingsController@index')->name('settings.students.general');
 Route::post('/students/general/update', 'Settings\StudentGeneralSettingsController@update')->name('settings.students.general.update');


 //Fees Settings
 Route::get('/fees', 'Settings\Fee\FeeSettingController@index')->name('settings.fees');
 Route::get('/fees/categories', 'Fee\FeeCategoryController@index')->name('settings.fees.categories');
 Route::post('/fees/categories/store', 'Fee\FeeCategoryController@store')->name('settings.fees.categories.store');
 Route::post('/fees/categories/update/{id}', 'Fee\FeeCategoryController@update')->name('settings.fees.categories.update');

 Route::get('/fees/structure/year/{year}/term/{term}', 'Fee\FeeStructureController')->name('settings.fees.structure');

 //Accounting Settings
 Route::view('/accounting/general', 'dashboard.settings.accounting.index')->name('settings.accounting');

 //Accounting Periods
 Route::get('/accounting/accounting-periods', 'Accounting\AccountingPeriodController@index')->name('settings.accounting.periods');
 Route::post('/accounting/periods/store', 'Accounting\AccountingPeriodController@store')->name('settings.accounting.periods.store');
 Route::post('/accounting/periods/update/{id}', 'Accounting\AccountingPeriodController@update')->name('settings.accounting.periods.update');

 Route::get('/accounting/accounting-period-options/{id}', 'Accounting\AccountingPeriodSettingController@index')->name('settings.accounting.period.settings');
 Route::post('/accounting/accounting-period-options/{id}/store', 'Accounting\AccountingPeriodSettingController@store')->name('settings.accounting.period.settings.store');


 Route::get('/accounting/expense-categories', 'Accounting\ExpenseCategoryController@index')->name('settings.expense.categories');

 //Fixed Asset SettingsP
 Route::get('/accounting/fixed-assets/asset-types', 'Asset\AssetTypeController@index')->name('settings.asset.types');
 Route::get('/accounting/fixed-assets/asset-types/create', 'Asset\AssetTypeController@create')->name('settings.asset.types.create');
 Route::post('/accounting/fixed-assets/asset-types/store', 'Asset\AssetTypeController@store')->name('settings.asset.types.store');

 Route::get('/accounting/fixed-assets/asset-status', 'Asset\AssetStatusController@index')->name('settings.asset.status');

 Route::get('/accounting/fixed-assets/coas', 'Asset\FixedAssetAccountController@index')->name('settings.fixed.asset.accounts');
 Route::post('/accounting/fixed-assets/coas/store', 'Asset\FixedAssetAccountController@store')->name('settings.fixed.asset.accounts.store');
 Route::get('/accounting/fixed-assets/coas/destroy/{id}', 'Asset\FixedAssetAccountController@destroy')->name('settings.fixed.asset.accounts.destroy');


 //School Settings
 Route::prefix('/school')->group(__DIR__.'/school.php');

 Route::get('/academics/subjects', 'Academics\SubjectController@index')->name('settings.academics.subjects');
 Route::post('/academics/subjects/store', 'Academics\SubjectController@store')->name('settings.academics.subjects.store');
 Route::get('/academics/subjects/show/{id}', 'Academics\SubjectController@show')->name('settings.academics.subjects.show');
 Route::get('/academics/subjects/destroy/{id}', 'Academics\SubjectController@destroy')->name('settings.academics.subjects.destroy');

 Route::get('/clazzs', 'Clazz\ClazzController@index')->name('settings.clazzs');
 Route::post('/clazzs/store', 'Clazz\ClazzController@store')->name('settings.clazzs.store');
 Route::get('/clazzs/destroy/{id}', 'Clazz\ClazzController@destroy')->name('settings.clazzs.destroy');
 Route::post('/clazzs/update/{id}', 'Clazz\ClazzController@update')->name('settings.clazzs.update');





});
















