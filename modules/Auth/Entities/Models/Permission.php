<?php

namespace Modules\Auth\Entities\Models;

use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use Uuid;

    protected $guarded = [];

    protected $table = 'ms_permissions';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'dt_permission_role')->withTimestamps();
    }
}
