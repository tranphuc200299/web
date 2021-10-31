<?php

namespace Modules\Tenant\Policies;

use Modules\Auth\Entities\Models\User;

trait TenantOwner
{
    public function hasOwnerEntity(User $auth, $object)
    {
        if (empty($object)) {
            return true;
        }

        return true;
    }
}
