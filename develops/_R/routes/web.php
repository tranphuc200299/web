<?php

use Illuminate\Support\Facades\Route;

/*Entities route*/
Route::group([], function () {
    Route::get('/r', 'Web\EntitiesController@index')->name('r.index');
    Route::get('/r/entities/{id}/edit', 'Web\EntitiesController@edit')->name('r.entities.edit');
    Route::get('/r/entities/{id}/migrate', 'Web\EntitiesController@migrate')->name('r.entities.migrate');
    Route::get('/r/entities/{id}/rollback', 'Web\EntitiesController@rollback')->name('r.entities.rollback');
    Route::get('/r/entities/{id}/factory', 'Web\EntitiesController@factory')->name('r.entities.factory');
    Route::get('/r/entities/{id}/destroy', 'Web\EntitiesController@destroy')->name('r.entities.destroy');
});

/*Generate code*/
Route::group([], function () {
    Route::get('/r/builder/create', 'Web\BuilderController@create')->name('r.builder.create');
    Route::get('/r/builder/relation_field_template',
        'Web\BuilderController@relation_field_template')->name('io_relation_field_template');
    Route::get('/r/builder/field_template', 'Web\BuilderController@field_template')->name('io_field_template');

    Route::post('/r/builder/generator_builder_generate',
        'Web\BuilderController@generator_builder_generate')->name('io_generator_builder_generate');
    Route::post('/r/builder/generator_builder_generate_from_file',
        'Web\BuilderController@generator_builder_generate_from_file')->name('io_generator_builder_generate_from_file');

    Route::get('/r/builder/io_generator_builder_get_field_list',
        'Web\BuilderController@get_field_list')->name('io_generator_builder_get_field_list');

    Route::post('/r/builder/preview',
        'Web\BuilderController@preview')->name('r.builder.preview');
});

/*Roles management tool*/
Route::group([], function () {
    Route::get('/r/roles', 'Web\RolesController@index')->name('r.roles.index');
    Route::get('/r/roles/create', 'Web\RolesController@create')->name('r.roles.create');
    Route::post('/r/roles', 'Web\RolesController@store')->name('r.roles.store');
    Route::delete('/r/roles/{id}', 'Web\RolesController@destroy')->name('r.roles.destroy');
});

/*Permissions sync with roles*/
Route::group([], function () {
    Route::get('/r/permissions', 'Web\PermissionsController@index')->name('r.permissions.index');
    Route::get('/r/permissions/create', 'Web\PermissionsController@create')->name('r.permissions.create');
    Route::delete('/r/permissions/{id}', 'Web\PermissionsController@destroy')->name('r.permissions.destroy');
    Route::post('/r/permissions/sync', 'Web\PermissionsController@sync')->name('r.permissions.sync');
});
