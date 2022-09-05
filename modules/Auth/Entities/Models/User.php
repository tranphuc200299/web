<?php


namespace Modules\Auth\Entities\Models;

use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Modules\Auth\Database\Factories\UserFactory;
use Modules\Auth\Entities\Mail\ResetPassword;

/**
 * Modules\Auth\Entities\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $picture
 * @property int $gender
 * @property int|null $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Auth\Entities\Models\UserDetail|null $detail
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Auth\Entities\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Uuid;
    use SoftDeletes;
    use Notifiable;
    use HasFactory;

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    protected $table = 'ms_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'user_name' , 'email', 'phone', 'ip_access', 'created_by', 'password', 'status', 'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'dt_user_role')->withTimestamps();
    }

    public function assignRole($role)
    {
        return $this->roles()->sync($role);
    }

    public function attachRoleByName($roleName)
    {
        $role = Role::whereName($roleName)->first();

        return $this->roles()->attach($role->id);
    }

    /**
     * @return Collection
     */
    public function permissions()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    public function roleNames()
    {
        return $this->roles->pluck('name');
    }

    public function hasRoleName($roleName)
    {
        return in_array($roleName, $this->roles->pluck('name')->toArray());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne | UserDetail
     */
    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function sendPasswordResetNotification($token)
    {
        activity()->send(new ResetPassword($this, $token));
    }

    public function isActive()
    {
        return $this->status === \Modules\Auth\Constants\AuthConst::STATUS_USER_ENABLE;
    }
}
