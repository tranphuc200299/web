<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

if (config('core.enable_view_log') === true) {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect(route('cp.logs.index'));
    })->name('home');

    Route::get('/cp', 'Web\TopController@index')
        ->name('cp');

    Route::post('cp/s/c/m', function () {
        Cookie::queue('pin', request('pin', 0));
        $pin = Cookie::get('pin');
        return json_encode(['pin' => $pin]);
    });
});