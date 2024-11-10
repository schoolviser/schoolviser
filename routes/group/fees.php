<?php

use Illuminate\Support\Facades\Route;

Route::get('/overview', 'Fee\FeeController@overview')->name('fees.overview');

Route::get('/student-ledger/{id}', 'Fee\StudentLedgerController')->name('fees.student.ledger');

//Fee Collection
Route::get('/collections', 'Fee\FeeCollectionController@index')->name('fees.collections');
Route::get('/collections/show/{id}', 'Fee\FeeCollectionController@show')->name('fees.collections.show');


Route::get('/discounts/year/{year}/term/{term}', 'Fee\FeeDiscountController@index')->name('fees.discounts')->middleware(['permissionViaSingleRole:can_view_fees_discounts']);
Route::post('/discounts/store/{termly_registration_id}', 'Fee\FeeDiscountController@store')->name('fees.discounts.store');
Route::get('/discounts/class/{clazz_id}', 'Fee\FeeDiscountController@index')->name('fees.discounts.class')->middleware(['permissionViaSingleRole:can_view_fees_discounts']);
Route::get('/discounts/show/{id}', 'Fee\FeeDiscountController@show')->name('fees.discounts.show')->middleware(['permissionViaSingleRole:can_view_fees_discounts']);
Route::get('/discounts/destroy/{id}', 'Fee\FeeDiscountController@destroy')->name('fees.discounts.destroy')->middleware(['permissionViaSingleRole:can_delete_fees_discount']);

Route::get('/fees-categories', 'FeeCategoryController@index')->name('fees.categories');
Route::get('/fees-categories/show/{id}', 'FeeCategoryController@show')->name('fees.categories.show');



Route::get('/fees-exemptions', 'FeeExemptionController@index')->name('fees.exemptions');
Route::get('/fees-exemptions/year/{year?}/term/{term?}', 'FeeExemptionController@index')->name('fees.exemptions.year.term');
Route::get('/fees-exemptions/show/{id}', 'FeeExemptionController@show')->name('fees.exemptions.show');
Route::get('/fees-exemptions/destroy/{id}', 'FeeExemptionController@destroy')->name('fees.exemptions.destroy');

Route::post('/fees-exemptions/update/{id}', 'FeeExemptionController@update')->name('fees.exemptions.update');

//Fee particulars ~ Fee Breakdowns
Route::get('/fees-particulars/{term_id}', 'FeeBreakdownController@index')->name('fees.breakdown');
Route::post('/fees-particulars/store/{term_id}', 'FeeBreakdownController@store')->name('fees.breakdown.store')->middleware(['permissionViaSingleRole:can_add_fees_breakdown']);

Route::get('/fees-breakdown/destroy/{id}', 'FeeBreakdownController@destroy')->name('fees.breakdown.destroy');
Route::post('/fees-breakdown/update/{id}', 'FeeBreakdownController@update')->name('fees.breakdown.update');


Route::get('/termlyfeesreview', 'Fee\TermlyFeesReviewController@index')->name('fees.termly.fees.review');
Route::get('/termlyfeesreview/class/{clazz_id}', 'Fee\TermlyFeesReviewController@ofClass')->name('fees.termly.fees.review.byclass');

/**
 * Fee Payments Routes
 */
Route::get('/fees-payments/year/{year}/term/{term}', 'Fee\FeePaymentController@index')->name('fees.payments')->middleware(['permissionViaSingleRole:can_view_fees_payments']);
Route::get('/fees-payments/year/{year}/term/{term}/class/{class}', 'Fee\FeePaymentController@indexOfClass')->name('fees.payments.class');

Route::get('/fees-payments/show/{id}', 'Fee\FeePaymentController@show')->name('fees.payments.show');

Route::post('/fees-payments/query', 'Fee\FeePaymentController@query')->name('fees.payments.query');
Route::get('/fees-payments/year/{year}/term/{term}/class/{class_id}', 'Fee\FeePaymentController@index')->name('fees.payments.ofClass');

Route::post('/fees-payments/record/{termly_registration_id}', 'Fee\FeePaymentController@store')->name('fees.payments.store')->middleware(['permissionViaSingleRole:can_record_fees_payment']);

#Fee Payments Import
Route::get('/import/fees-payments', 'Fee\FeePaymentsImportController@index')->name('fees.import.payments')->middleware(['permissionViaSingleRole:can_import_fees_payments']);
Route::get('/import/school-pay-payments-transactions', 'Fee\FeePaymentsImportController@index')->name('fees.import.school.pay.transactions')->middleware(['permissionViaSingleRole:can_import_fees_payments']);
Route::post('/fees-payments/import/process', 'Fee\FeePaymentsImportController@import')->name('fees.payments.import.process')->middleware(['permissionViaSingleRole:can_import_fees_payments']);

# Fee Payment Transactions
Route::get('/payments/transactions/year/{year}/term/{term}', 'Fee\PaymentTransactionController@index')->name('fees.payments.transactions.termly')->middleware(['permissionViaSingleRole:can_view_fees_payments_transactions']);

Route::get('/payments/transaction/{transaction_id}', 'Fee\PaymentTransactionController@show')->name('fees.payments.transactions.show');


Route::get('/summary', 'Fee\TermlyFeeSummaryController')->name('fees.summary');


//Individual Fees & Fines
Route::get('/individualfees', 'Fee\IndividualFeeController@index')->name('fees.individual.fees');
 Route::post('/individualfees/store/{termly_registration_id}', 'Fee\IndividualFeeController@store')->name('fees.individualfee.store');

 Route::post('/individualfees/update/{id}', 'Fee\IndividualFeeController@update')->name('fees.individualfee.update');
 Route::get('/individualfees/destroy/{id}', 'Fee\IndividualFeeController@destroy')->name('fees.individualfee.delete');
 Route::get('/individualfees/show/{id}', 'Fee\IndividualFeeController@show')->name('fees.individualfee.show');

 /**
  * Fee Payment Transactions
  */
Route::get('/fee-payment-transactions', 'Fee\FeePaymentTransactionController@index')->name('fees.payments.transactions')->middleware('permissionViaSingleRole:can_view_revenue');







