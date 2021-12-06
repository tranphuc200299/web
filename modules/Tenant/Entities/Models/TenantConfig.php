<?php

namespace Modules\Tenant\Entities\Models;

use Core\Entities\Models\BaseModel;
use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Package\Modules\Auth\Entities\Models\TenantConfig
 *
 * @property string $id
 * @property string $group_id
 * @property string|null $icon
 * @property string|null $image
 * @property string|null $image_cover
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\Tenant\Entities\Models\TenantModel $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig newQuery()
 * @method static \Illuminate\Database\Query\Builder|TenantConfig onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereImageCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TenantConfig withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TenantConfig withoutTrashed()
 * @mixin \Eloquent
 * @property string $tenant_id
 * @method static \Illuminate\Database\Eloquent\Builder|TenantConfig whereTenantId($value)
 */
class TenantConfig extends BaseModel
{
    use SoftDeletes, Uuid;

    protected $guarded = [];

    protected $table = 'ms_tenant_configs';

    protected $fillable = [
        'tenant_id',
        'icon',
        'image',
        'image_cover'
    ];

    public function tenant()
    {
        return $this->belongsTo(TenantModel::class);
    }
}
