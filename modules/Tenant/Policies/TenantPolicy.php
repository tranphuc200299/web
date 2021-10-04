<?php

namespace Modules\Tenant\Policies;

use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function read(User $user)
    {
        //Return true if a user has permission to view-tenant
        return $user->permissions()->contains('tenant'.AuthConst::PERMISSION_READ);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //Return true if a user has permission to create-tenant
        return $user->permissions()->contains('tenant'.AuthConst::PERMISSION_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        //Return true if the authenticated user has the same id with specified model/user id 
        //or has permission to update-tenant
        return $user->permissions()->contains('tenant'.AuthConst::PERMISSION_UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return mixed
     */
    public function delete(User $user)
    {
        //Return true if an authenticated user has permission to delete-tenant
        return $user->permissions()->contains('tenant'.AuthConst::PERMISSION_DELETE);
    }
}
