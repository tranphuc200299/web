<?php

namespace Modules\Auth\Services;

use Core\Services\BaseService;
use Modules\Auth\Repositories\UserRepository;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        $this->mainRepository = $repository;
    }
}
