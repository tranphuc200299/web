<?php

namespace Modules\Auth\Services;

use Core\Constants\AppConst;
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

    public function getAll($options = [], $limit = AppConst::PAGE_LIMIT_DEFAULT)
    {
        $options['limit'] = $limit;
        $this->makeBuilder($options);

        $this->builder->orderBy('created_at', 'asc');

        return $this->endFilter();
    }
}
