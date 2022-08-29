<?php

namespace Modules\Log\Entities\Models;

use Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Log\Entities\Models\LogModel
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
 * @property-read LogConfig|null $config
 * @property-read Log|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerModel extends Model
{
//    use Uuid;
    protected $guarded = [];

    protected $table = 'users';

    protected $fillable = ['age', 'gender', 'created_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function log()
    {
        return $this->hasMany(LogModel::class);
    }

//    public function owner()
//    {
//        return $this->belongsTo(Log::class, 'created_by');
//    }
//
//    public function config()
//    {
//        return $this->hasOne(LogConfig::class, 'Log_id');
//    }
}
