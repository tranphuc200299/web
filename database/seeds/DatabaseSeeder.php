<?php

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seed\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Modules\Auth\Database\Seed\DatabaseSeeder::class);
        $this->call(Modules\Tenant\Database\Seed\DatabaseSeeder::class);
        $this->call(Modules\Auth\Database\Seed\PermissionSeeder::class);
    }
}
