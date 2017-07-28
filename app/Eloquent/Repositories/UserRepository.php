<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends AbstractRepository
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
        return $this->model->where(function (Builder $q) use ($id) {
            $id = explode('|', $id);
            $q->whereIn('email', $id)->orWhereIn('id', $id);
        })
            ->orderBy('id', 'ASC')
            ->get()
            ;
    }
}
