<?php

namespace Modules\Customer\Repositories;

use Core\Repositories\BaseRepository;
use Modules\Customer\Entities\Models\CustomerModel;

class CustomerRepository extends BaseRepository
{
    public function model()
    {
        return CustomerModel::class;
    }

}
