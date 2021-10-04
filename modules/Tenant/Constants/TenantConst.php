<?php

namespace Modules\Tenant\Constants;

class TenantConst
{
    const ROLE_TENANT_ADMIN = 'role.tenant-admin';
    const ROLE_LEVEL_TENANT = 1;

    const TENANT_STATUS_ENABLE = 1;
    const TENANT_STATUS_DISABLE = 0;

    const PERMISSION_CREATE = '.create';
    const PERMISSION_READ = '.read';
    const PERMISSION_UPDATE = '.update';
    const PERMISSION_DELETE = '.delete';
}
