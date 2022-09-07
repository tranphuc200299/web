<?php

namespace Modules\Customer\Repositories;

use Core\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;
use Modules\Customer\Entities\Models\CustomerModel;
use Modules\Log\Entities\Models\LogModel;

class CustomerRepository extends BaseRepository
{
    public function model()
    {
        return CustomerModel::class;
    }

    public function deleteMultiRecord($listId)
    {
        return $this->model->whereIn('id', $listId)->delete();
    }

    public function deleteAll()
    {
        $this->model->where('id', '!=', 0)->delete();
        Schema::disableForeignKeyConstraints();
        $this->model->truncate();
        Schema::enableForeignKeyConstraints();
    }

}
