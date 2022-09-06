<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth'], 'prefix' => 'cp'], function () {
    Route::group(['prefix' => 'customers'], function () {
        Route::get('', 'Web\CustomerController@index')
            ->name('cp.customers.index');
        Route::post('destroy', 'Web\CustomerController@destroy')
            ->name('cp.customers.destroy');
        Route::post('deleteAll', 'Web\CustomerController@deleteAll')
            ->name('cp.customers.deleteAll');
//        Route::get('/export', 'Web\LogController@export')
//            ->name('cp.logs.export');
//        Route::get('/download', 'Web\LogController@download')
//            ->name('cp.logs.download');
    });
});

