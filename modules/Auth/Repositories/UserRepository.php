<?php

namespace Modules\Auth\Repositories;

use Core\Repositories\BaseRepository;
use Modules\Auth\Entities\Models\User;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getAll()
    {
        return $this->model->get();
    }
}
