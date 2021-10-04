<?php

namespace Modules\Tenant\Services;

use Core\Services\BaseService;
use Modules\Tenant\Repositories\TenantRepository;

class TenantService extends BaseService
{
    public function __construct(TenantRepository $repository)
    {
        $this->mainRepository = $repository;
    }
}
