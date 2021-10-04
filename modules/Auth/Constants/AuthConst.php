<?php

namespace Modules\Auth\Constants;

class AuthConst
{
    const ROLE_SUPER_ADMIN = 'role.super-admin';
    const ROLE_LEVEL_IT_ADMIN = 0;

    const PERMISSION_CREATE = '.create';
    const PERMISSION_READ = '.read';
    const PERMISSION_UPDATE = '.update';
    const PERMISSION_DELETE = '.delete';

    const USER_ENABLE = 1;
    const USER_DISABLE = 0;

    const USER_GENDER_OTHER = 0;
    const USER_GENDER_MALE = 1;
    const USER_GENDER_FEMALE = 2;

    const STATUS_USER_ENABLE = 1;
    const STATUS_USER_DISABLE = 0;

    const STATUS_GROUP_ENABLE = 1;
    const STATUS_GROUP_DISABLE = 0;
}
