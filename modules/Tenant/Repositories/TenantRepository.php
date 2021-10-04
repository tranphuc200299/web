<?php

namespace Modules\Tenant\Repositories;

use Core\Repositories\BaseRepository;
use Modules\Tenant\Entities\Models\TenantModel;

class TenantRepository extends BaseRepository
{
    public function model()
    {
        return TenantModel::class;
    }
}
