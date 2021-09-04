<?php

namespace Develops\_R\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class Entities extends Model
{
    protected $guarded = [];

    protected $table = 'r_entities';

    protected $casts = [
        'config_json' => 'array',
        'migration_files_json' => 'array'
    ];
}
