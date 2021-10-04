<?php

namespace Modules\Auth\Services;

use Core\Services\BaseService;
use Illuminate\Support\Str;
use Modules\Auth\Repositories\UserRepository;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        $this->mainRepository = $repository;
    }

    public function makePassword()
    {
        return Str::random(8);
    }
}
