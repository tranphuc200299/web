<?php

namespace Modules\Tenant\Entities\Models;

use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Entities\Models\TenantConfig;
use Modules\Auth\Entities\Models\User;

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
