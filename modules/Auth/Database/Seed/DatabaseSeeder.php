<?php

namespace Modules\Auth\Database\Seed;

use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Models\Permission;
use Modules\Auth\Entities\Models\User;
use Modules\Auth\Entities\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $superAdmin = User::factory()->create(
            ['full_name' => 'SuperAdmin', 'user_name' => 'Admin', 'email' => 'super@ntq.cms']
        );

        $superAdmin->detail()->create();

        $superAdminRole = Role::factory()->create(['name' => AuthConst::ROLE_SUPER_ADMIN, 'display_name' => 'auth::role.name.Admin', 'description' => 'Role super admin, allowed every action']);

        $superAdmin->assignRole($superAdminRole);
    }
}
