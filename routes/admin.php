<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'AdminController@dashboard')->name('index');
Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
Route::get('/heatmap', 'AdminController@heatmap')->name('heatmap');
Route::get('/translation',  'AdminController@translation')->name('translation');

Route::group(['as' => 'dispatcher.', 'prefix' => 'dispatcher'], function () {
	Route::get('/', 'DispatcherController@index')->name('index');
	Route::post('/', 'DispatcherController@store')->name('store');
    Route::get('/trips', 'DispatcherController@trips')->name('trips');
    Route::get('/cancelled', 'DispatcherController@cancelled')->name('cancelled');
	Route::get('/cancel', 'DispatcherController@cancel')->name('cancel');
	Route::get('/trips/{trip}/{provider}', 'DispatcherController@assign')->name('assign');
	Route::get('/users', 'DispatcherController@users')->name('users');
	Route::get('/providers', 'DispatcherController@providers')->name('providers');
});

Route::resource('user', 'Resource\UserResource');
Route::resource('dispatch-manager', 'Resource\DispatcherResource');
Route::resource('account-manager', 'Resource\AccountResource');
Route::resource('fleet', 'Resource\FleetResource');
Route::resource('provider', 'Resource\ProviderResource');
Route::resource('document', 'Resource\DocumentResource');
Route::resource('service', 'Resource\ServiceResource');
Route::resource('promocode', 'Resource\PromocodeResource');

Route::group(['as' => 'provider.'], function () {
    Route::get('review/provider', 'AdminController@provider_review')->name('review');
    Route::get('provider/{id}/approve', 'Resource\ProviderResource@approve')->name('approve');
    Route::get('provider/{id}/disapprove', 'Resource\ProviderResource@disapprove')->name('disapprove');
    Route::get('provider/{id}/request', 'Resource\ProviderResource@request')->name('request');
    Route::get('provider/{id}/statement', 'Resource\ProviderResource@statement')->name('statement');
    Route::resource('provider/{provider}/document', 'Resource\ProviderDocumentResource');
    Route::delete('provider/{provider}/service/{document}', 'Resource\ProviderDocumentResource@service_destroy')->name('document.service');
});

Route::get('review/user', 'AdminController@user_review')->name('user.review');
Route::get('user/{id}/request', 'Resource\UserResource@request')->name('user.request');

Route::get('map', 'AdminController@map_index')->name('map.index');
Route::get('map/ajax', 'AdminController@map_ajax')->name('map.ajax');

Route::get('settings', 'AdminController@settings')->name('settings');
Route::post('settings/store', 'AdminController@settings_store')->name('settings.store');
Route::get('settings/payment', 'AdminController@settings_payment')->name('settings.payment');
Route::post('settings/payment', 'AdminController@settings_payment_store')->name('settings.payment.store');

Route::get('profile', 'AdminController@profile')->name('profile');
Route::post('profile', 'AdminController@profile_update')->name('profile.update');

Route::get('password', 'AdminController@password')->name('password');
Route::post('password', 'AdminController@password_update')->name('password.update');

Route::get('payment', 'AdminController@payment')->name('payment');

// statements

Route::get('/statement', 'AdminController@statement')->name('ride.statement');
Route::get('/statement/provider', 'AdminController@statement_provider')->name('ride.statement.provider');
Route::get('/statement/today', 'AdminController@statement_today')->name('ride.statement.today');
Route::get('/statement/monthly', 'AdminController@statement_monthly')->name('ride.statement.monthly');
Route::get('/statement/yearly', 'AdminController@statement_yearly')->name('ride.statement.yearly');


// Static Pages - Post updates to pages.update when adding new static pages.

Route::get('/help', 'AdminController@help')->name('help');
Route::get('/send/push', 'AdminController@push')->name('push');
Route::post('/send/push', 'AdminController@send_push')->name('send.push');
Route::get('/privacy', 'AdminController@privacy')->name('privacy');
Route::post('/pages', 'AdminController@pages')->name('pages.update');
Route::resource('requests', 'Resource\TripResource');
Route::get('scheduled', 'Resource\TripResource@scheduled')->name('requests.scheduled');

Route::get('push', 'AdminController@push_index')->name('push.index');
Route::post('push', 'AdminController@push_store')->name('push.store');
