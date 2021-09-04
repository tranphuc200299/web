<?php

namespace Core\Entities\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @package Core\Entities\Models
 */
class BaseModel extends Model
{
    protected $connection = 'mysql';
}
