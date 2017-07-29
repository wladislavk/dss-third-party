<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Database\Eloquent\Builder;
use DentalSleepSolutions\Auth\Legacy;

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
            $id = explode(Legacy::LOGIN_ID_DELIMITER, $id, 2);
            $q->whereIn('email', $id)->orWhereIn('id', $id);
        })
            ->orderBy('id', 'ASC')
            ->get()
            ;
    }
}
