<?php

namespace Modules\Auth\Entities\Models;

use Core\Entities\Models\BaseModel;
use Core\Entities\Models\Uuid;

/**
 * Modules\Auth\Entities\Models\UserDetail
 *
 * @property string $id
 * @property string $user_id
 * @property int|null $group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Auth\Entities\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUserId($value)
 * @mixin \Eloquent
 */
class UserDetail extends BaseModel
{
    use Uuid;

    protected $table = 'ms_user_detail';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
