<?php

namespace Modules\Tenant\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Models\User;
use Modules\Tenant\Entities\Models\TenantModel;

class TenantPolicy
{
    use HandlesAuthorization, TenantOwner;

    public function read(User $auth, TenantModel $tenant = null)
    {
        return $auth->permissions()->contains('tenant' . AuthConst::PERMISSION_READ) && $this->hasOwnerEntity($auth, $tenant);
    }

    public function create(User $auth)
    {
        return $auth->permissions()->contains('tenant' . AuthConst::PERMISSION_CREATE);
    }

    public function update(User $auth, TenantModel $tenant = null)
    {
        return $auth->permissions()->contains('tenant' . AuthConst::PERMISSION_UPDATE) && $this->hasOwnerEntity($auth, $tenant);
    }

    public function delete(User $auth, TenantModel $tenant = null)
    {
        return $auth->permissions()->contains('tenant' . AuthConst::PERMISSION_DELETE) && $this->hasOwnerEntity($auth, $tenant);
    }
}
