<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\StaticClasses\SudoHelper;

class UserRepository extends AbstractRepository
{
    public function model()
    {
        return User::class;
    }

    /**
     * @param int|string $id
     * @param array $columns
     * @return User|null
     */
    public function findById($id, $columns = ['*'])
    {
        if (!SudoHelper::isSudoId($id)) {
            return $this->model->where('id', $id)
                ->orderBy('id', 'ASC')
                ->get($columns)
                ;
        }

        $sudoId = SudoHelper::parseId($id);
        $ids = [
            $sudoId->id,
            $sudoId->adminId,
            $sudoId->userId,
        ];

        return $this->model->whereIn('id', $ids)
            ->orderBy('id', 'ASC')
            ->get($columns)
            ;
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param array $columns
     * @return \DentalSleepSolutions\Eloquent\Models\User|mixed|null
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        if ($field === 'id') {
            return self::findById($value, $columns);
        }

        return parent::findByField($field, $value, $columns);
    }
}
