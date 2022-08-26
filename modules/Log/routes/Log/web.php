<?php

use Illuminate\Support\Facades\Route;
use Modules\Log\Entities\Models\LogModel;

Route::group(['middleware' => ['auth'], 'prefix' => 'cp'], function () {
    Route::group(['prefix' => 'logs'], function () {
        Route::get('', 'Web\LogController@index')
            ->name('cp.logs.index');
        Route::post('destroy', 'Web\LogController@destroy')
            ->name('cp.logs.destroy');
        Route::get('/export', 'Web\LogController@export')
            ->name('cp.logs.export');
        Route::get('/download', 'Web\LogController@download')
            ->name('cp.logs.download');
    });
});

