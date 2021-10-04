<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenant\Entities\Models\TenantModel;

Route::group(['middleware' => ['auth']], function () {
    /*List*/
    Route::get('/cp/tenants', 'Web\TenantController@index')
        ->name('cp.tenants.index')->middleware('can:read,'.TenantModel::class);

    /*Create*/
    Route::get('/cp/tenants/create', 'Web\TenantController@create')
        ->name('cp.tenants.create')->middleware('can:create,'.TenantModel::class);

    Route::post('/cp/tenants', 'Web\TenantController@store')
        ->name('cp.tenants.store')->middleware('can:create,'.TenantModel::class);

    /*Detail*/
    Route::get('/cp/tenants/{tenant}', 'Web\TenantController@show')
        ->name('cp.tenants.show')->middleware('can:read,tenant');

    /*Edit*/
    Route::get('/cp/tenants/{tenant}/edit', 'Web\TenantController@edit')
        ->name('cp.tenants.edit')->middleware('can:update,tenant');

    Route::match(['POST', 'PUT', 'PATCH'], '/cp/tenants/{tenant}', 'Web\TenantController@update')
        ->name('cp.tenants.update')->middleware('can:update,tenant');

    /*Delete*/
    Route::delete('/cp/tenants/{tenant}', 'Web\TenantController@destroy')
        ->name('cp.tenants.destroy')->middleware('can:delete,tenant');

    Route::get('/cp/tenants/ajax/search', 'Web\TenantController@ajaxSearch')
           ->name('cp.tenants.ajax')->middleware('can:read,'.TenantModel::class);
});
