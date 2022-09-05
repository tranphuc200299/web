<?php

namespace Modules\Customer\Services;

use Core\Services\BaseService;
use Modules\Customer\Repositories\CustomerRepository;
use Core\Constants\AppConst;

class CustomerService extends BaseService
{
    public function __construct(CustomerRepository $repository)
    {
        $this->mainRepository = $repository;
    }

    public function getAll($options = [], $limit = AppConst::PAGE_LIMIT_DEFAULT)
    {
        $options['limit'] = $limit;
        $this->makeBuilder($options);

        $this->builder->orderBy('created_at', 'asc');

        return $this->endFilter();
    }
}
