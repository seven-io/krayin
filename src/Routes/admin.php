<?php

use Seven\Krayin\Http\Controllers\SevenController;

Route::group([
    'middleware' => ['web', 'user'],
    'namespace' => 'Seven\Krayin\Http\Controllers',
    'prefix' => config('app.admin_path'),
], function () {

    Route::group(['prefix' => 'seven'], function () {
        Route::get('', [SevenController::class, 'index'])->name('admin.seven.index');
        Route::post('sms', [SevenController::class, 'smsSend'])->name('admin.seven.sms_submit');
    });

    Route::group(['prefix' => 'contacts'], function () {
        Route::prefix('persons')->group(function () {
            Route::group(['prefix' => 'seven'], function () {
                Route::get('sms/{id}', [SevenController::class, 'smsPerson'])->name('admin.seven.sms');
            });
        });

        Route::prefix('organizations')->group(function () {
            Route::group(['prefix' => 'seven'], function () {
                Route::get('sms/{id}', [SevenController::class, 'smsOrganization'])
                    ->name('admin.seven.sms_organization');
            });
        });
    });
});
