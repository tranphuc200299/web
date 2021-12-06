<?php

namespace Modules\Tenant\Entities\Models;

use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Entities\Models\TenantConfig;
use Modules\Auth\Entities\Models\User;

/**
 * Modules\Tenant\Entities\Models\TenantModel
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string $status
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read TenantConfig|null $config
 * @property-read User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TenantModel extends Model
{
    use Uuid;
    protected $guarded = [];

    protected $table = 'ms_tenants';

    protected $fillable = ['name', 'email', 'phone', 'address'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function config()
    {
        return $this->hasOne(TenantConfig::class, 'tenant_id');
    }
}
