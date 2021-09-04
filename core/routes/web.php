<?php

use Illuminate\Support\Facades\Route;

if (config('core.enable_view_log') === true) {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}


Route::group(['middleware' => 'auth'], function () {
    Route::get('cp', function () {
        return view('core::index');
    })->name('cp');


    Route::get('/', function () {
        return view('core::index');
    });
});
