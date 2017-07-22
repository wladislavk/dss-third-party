<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findByIdOrEmail($id)
    {
        return $this->model->where(function ($q) use ($id) {
            $q->where('email', $id)->orWhere('id', $id);
        })->first();
    }
}
