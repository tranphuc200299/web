<?php

namespace Modules\Tenant\Database\Seed;

use Illuminate\Database\Seeder;
use Modules\Auth\Entities\Models\Role;
use Modules\Tenant\Constants\TenantConst;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create([
            'name'         => TenantConst::ROLE_TENANT_ADMIN,
            'level'        => TenantConst::ROLE_LEVEL_TENANT,
            'display_name' => 'tenant::role.name.tenant',
            'description'  => 'Role tenant, allowed every action with owned by the tenant'
        ]);
    }
}
