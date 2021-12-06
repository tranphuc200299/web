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
        $superAdmin = factory(User::class)->create(['name' => 'SuperAdmin', 'email' => 'super@mail.io']);
        $superAdmin->detail()->create();

        $superAdminRole = factory(Role::class)->create(['name' => AuthConst::ROLE_SUPER_ADMIN, 'display_name' => 'auth::role.name.ITAdmin', 'description' => 'Role super admin, allowed every action']);
        $superAdmin->assignRole($superAdminRole);
    }
}
