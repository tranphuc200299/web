<?php

namespace Modules\Log\Repositories;

use Core\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;
use Modules\Log\Entities\Models\LogModel;

class LogRepository extends BaseRepository
{
    public function model()
    {
        return LogModel::class;
    }

    public function deleteMultiRecord($listId)
    {
        return $this->model->whereIn('id', $listId)->delete();
    }

    public function deleteAll()
    {
        $this->model->where('id', '!=', '0')->delete();
    }

    public function getByListId($listId)
    {
        return $this->model->whereIn('id',$listId)->get();
    }

}
