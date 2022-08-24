<?php

use Illuminate\Support\Facades\Route;
use Modules\Log\Entities\Models\LogModel;

Route::group(['middleware' => ['auth']], function () {
    /*List*/
    Route::get('/cp/logs', 'Web\LogController@index')
        ->name('cp.logs.index');

//    /*Create*/
//    Route::get('/cp/logs/create', 'Web\LogController@create')
//        ->name('cp.logs.create')->middleware('can:create,'.LogModel::class);
//
//    Route::post('/cp/logs', 'Web\LogController@store')
//        ->name('cp.logs.store')->middleware('can:create,'.LogModel::class);
//
//    /*Detail*/
//    Route::get('/cp/logs/{log}', 'Web\LogController@show')
//        ->name('cp.logs.show')->middleware('can:read,log');
//
//    /*Edit*/
//    Route::get('/cp/logs/{log}/edit', 'Web\LogController@edit')
//        ->name('cp.logs.edit')->middleware('can:update,log');
//
//    Route::match(['POST', 'PUT', 'PATCH'], '/cp/logs/{log}', 'Web\LogController@update')
//        ->name('cp.logs.update')->middleware('can:update,log');
//
//    /*Delete*/
//    Route::delete('/cp/logs/{log}', 'Web\LogController@destroy')
//        ->name('cp.logs.destroy')->middleware('can:delete,log');
//
//    Route::get('/cp/logs/ajax/search', 'Web\LogController@ajaxSearch')
//           ->name('cp.logs.ajax')->middleware('can:read,'.LogModel::class);
});
