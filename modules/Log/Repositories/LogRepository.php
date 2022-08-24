<?php

namespace Modules\Log\Repositories;

use Core\Repositories\BaseRepository;
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

}
