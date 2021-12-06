<?php

namespace Modules\Auth\Entities\Models;

use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Auth\Entities\Models\Role
 *
 * @property string $id
 * @property string $name
 * @property string|null $display_name
 * @property int $level
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Auth\Entities\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Auth\Entities\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
