<?php

namespace Modules\Auth\Database\Factories;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'user_name' => $this->faker->unique()->name,
            'email' => $this->faker->safeEmail,
            'status' => \Modules\Auth\Constants\AuthConst::USER_ENABLE,
            'email_verified_at' => now(),
            'password' => Hash::make('123456'), // password
            'remember_token' => Str::random(10),
        ];
    }
}