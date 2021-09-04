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
        //New Users
        $superAdmin = factory(User::class)->create(['name' => 'SuperAdmin', 'email' => 'super@mail.io']);
        $superAdminRole = factory(Role::class)->create(['name' => AuthConst::ROLE_SUPER_ADMIN, 'description' => 'Role super admin, allowed every action']);
        $superAdmin->assignRole($superAdminRole);

        factory(Permission::class)->create(['name' => 'user'.AuthConst::PERMISSION_CREATE, 'description' => 'Create entities, show button create']);
        factory(Permission::class)->create(['name' => 'user'.AuthConst::PERMISSION_READ, 'description' => 'View list entities,show link in menu']);
        factory(Permission::class)->create(['name' => 'user'.AuthConst::PERMISSION_UPDATE, 'description' => 'Update entities, show button edit']);
        factory(Permission::class)->create(['name' => 'user'.AuthConst::PERMISSION_DELETE, 'description' => 'Delete entities, show button delete']);

//        $admin = factory(User::class)->create(['name' => 'Admin', 'email' => 'admin@mail.io']);
//        $editor = factory(User::class)->create(['name' => 'Editor', 'email' => 'editor@mail.io']);
//        $viewer = factory(User::class)->create(['name' => 'Viewer', 'email' => 'viewer@mail.io']);
//        factory(User::class)->create(['name' => 'No Role', 'email' => 'no_role@mail.io']);

        //New Roles

//        $adminRole = factory(Role::class)->create(['name' => 'admin']);
//        $viewerRole = factory(Role::class)->create(['name' => 'viewer']);
//        $editorRole = factory(Role::class)->create(['name' => 'editor']);

        //Assign Each Profile with Permissions
//        $viewerRole->allowTo($view_user);
//
//        $editorRole->allowTo($update_user);
//        $editorRole->allowTo($view_user);
//
//        $adminRole->allowTo($create_user);
//        $adminRole->allowTo($update_user);
//        $adminRole->allowTo($delete_user);
//        $adminRole->allowTo($view_user);

        //Assign Each User with Profiles

//        $admin->assignRole($adminRole);
//        $editor->assignRole($editorRole);
//        $viewer->assignRole($viewerRole);

    }
}
