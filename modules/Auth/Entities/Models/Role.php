<?php

namespace Modules\Auth\Entities\Models;

use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Uuid;

    protected $guarded = [];

    protected $table   = 'ms_roles';

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'dt_permission_role')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'dt_user_role')->withTimestamps();
    }

    public function allowTo($permission)
    {
        return $this->permissions()->save($permission);
    }

}
