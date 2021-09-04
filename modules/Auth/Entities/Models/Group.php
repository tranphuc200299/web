<?php

namespace Modules\Auth\Entities\Models;

use Core\Entities\Models\BaseModel;
use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Package\Modules\Auth\Entities\Models\Group
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\Auth\Entities\Models\GroupConfig|null $config
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Auth\Entities\Models\UserDetail[] $userDetail
 * @property-read int|null $user_detail_count
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Query\Builder|Group onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Group withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Group withoutTrashed()
 * @mixin \Eloquent
 */
class Group extends BaseModel
{
    use SoftDeletes, Uuid;

    protected $guarded = [];

    protected $table = 'ms_groups';

    protected $fillable = [
        'name', 'email', 'phone', 'description', 'status'
    ];

    public function userDetail()
    {
        return $this->hasMany(UserDetail::class);
    }

    public function config()
    {
        return $this->hasOne(GroupConfig::class);
    }
}
