<?php

Route::get('/', 'DispatcherController@index')->name('index');

Route::group(['as' => 'dispatcher.', 'prefix' => 'dispatcher'], function () {
	Route::get('/', 'DispatcherController@index')->name('index');
	Route::post('/', 'DispatcherController@store')->name('store');
	Route::get('/trips', 'DispatcherController@trips')->name('trips');
	Route::get('/trips/{trip}/{provider}', 'DispatcherController@assign')->name('assign');
	Route::get('/users', 'DispatcherController@users')->name('users');
	Route::get('/providers', 'DispatcherController@providers')->name('providers');
});


Route::get('password', 'DispatcherController@password')->name('password');
Route::post('password', 'DispatcherController@password_update')->name('password.update');

Route::get('profile', 'DispatcherController@profile')->name('profile');
Route::post('profile', 'DispatcherController@profile_update')->name('profile.update');