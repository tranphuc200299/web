<?php

namespace Modules\Auth\Entities\Models;

use Core\Entities\Models\BaseModel;
use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Package\Modules\Auth\Entities\Models\GroupConfig
 *
 * @property string $id
 * @property string $group_id
 * @property string|null $icon
 * @property string|null $image
 * @property string|null $image_cover
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\Auth\Entities\Models\Group $group
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig newQuery()
 * @method static \Illuminate\Database\Query\Builder|GroupConfig onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig whereImageCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|GroupConfig withTrashed()
 * @method static \Illuminate\Database\Query\Builder|GroupConfig withoutTrashed()
 * @mixin \Eloquent
 */
class GroupConfig extends BaseModel
{
    use SoftDeletes, Uuid;

    protected $guarded = [];

    protected $table = 'ms_group_configs';

    protected $fillable = [
        'group_id', 'icon', 'image', 'image_cover'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
