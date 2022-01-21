<?php

use Sms77\Krayin\Http\Controllers\Sms77Controller;

Route::group([
    'middleware' => ['web', 'user'],
    'namespace' => 'Sms77\Krayin\Http\Controllers',
    'prefix' => config('app.admin_path'),
], function () {

    Route::group(['prefix' => 'sms77'], function () {
        Route::get('', [Sms77Controller::class, 'index'])
            ->name('admin.sms77.index');
        Route::post('sms', [Sms77Controller::class, 'smsSend'])
            ->name('admin.sms77.sms_submit');
    });

    Route::group(['prefix' => 'contacts'], function () {
        Route::prefix('persons')->group(function () {
            Route::group(['prefix' => 'sms77'], function () {
                Route::get('sms/{id}', [Sms77Controller::class, 'smsPerson'])
                    ->name('admin.sms77.sms');
            });
        });

        Route::prefix('organizations')->group(function () {
            Route::group(['prefix' => 'sms77'], function () {
                Route::get('sms/{id}', [Sms77Controller::class, 'smsOrganization'])
                    ->name('admin.sms77.sms_organization');
            });
        });
    });
});