<?php


namespace Modules\Auth\Entities\Models;

use Core\Entities\Models\Uuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Auth\Entities\Mail\ResetPassword;

class User extends Authenticatable
{
    use Uuid;

    use Notifiable;

    protected $table = 'ms_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'ip_access', 'created_by', 'password', 'status'
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
