<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Modules\Auth\Entities\Models\User;
use Modules\Auth\Entities\Models\Role;
use Modules\Auth\Entities\Models\Permission;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'status' => \Modules\Auth\Constants\AuthConst::USER_ENABLE,
        'email_verified_at' => now(),
        'password' => Hash::make('123456'), // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->word,
    ];
});

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->word,
    ];
});
