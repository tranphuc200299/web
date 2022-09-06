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
//        dd($this->filter->get('id'));
        $this->builder
             ->when($this->filter->has('age_start'), function ($q) {
                    $q->where('age', '>=', $this->filter->get('age_start'));
                })->when($this->filter->has('age_end'), function ($q) {
                    $q->where('age', '<=', $this->filter->get('age_end'));
                })->when($this->filter->has('gender'), function ($q) {
                    $q->where('gender', $this->filter->get('gender'));
                })->when($this->filter->has('id'), function ($q) {
                    $q->where('id', 'LIKE', "%" . str_replace('ID', '', $this->filter->get('id')) . "%");
                })->orderByDesc('created_at');
//        $this->builder->orderBy('created_at', 'asc');
        $this->cleanFilterBuilder(['id', 'age_start', 'age_end', 'gender']);

        return $this->endFilter();
    }

    public function deleteMultiRecord($listId)
    {
        return $this->mainRepository->deleteMultiRecord($listId);
    }

    public function deleteAll()
    {
        return $this->mainRepository->deleteAll();
    }
}
