<?php

Route::group([
    'middleware' => ['web', 'user'],
    'namespace' => 'Sms77\Krayin\Http\Controllers',
    'prefix' => config('app.admin_path'),
], function () {

    Route::group(['prefix' => 'sms77'], function () {
        Route::get('', 'Sms77Controller@index')->name('admin.sms77.index');
        Route::post('sms', 'Sms77Controller@smsSend')->name('admin.sms77.sms_submit');
    });

    Route::group(['prefix' => 'contacts'], function () {
        Route::prefix('persons')->group(function () {
            Route::group(['prefix' => 'sms77'], function () {
                Route::get('sms/{id?}', 'Sms77Controller@sms')->name('admin.sms77.sms');
            });
        });
    });
});