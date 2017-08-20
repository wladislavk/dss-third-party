<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\User;

class UserRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param int|string $id
     * @param array $columns
     * @return User
     */
    public function findById($id, $columns = ['*'])
    {
        return $this->findByField('id', $id, $columns)
            ->first()
            ;
    }

    /**
     * @param array $where
     * @return User|null
     */
    public function findByCredentials(array $where)
    {
        $password = null;

        if (isset($where['password']) && is_string($where['password'])) {
            $password = $where['password'];
        }

        $user = $this->findWhere($where)
            ->first()
            ;

        if (is_null($user) || is_null($password)) {
            return $user;
        }

        $hash = $this->genPassword($password, $user->salt);

        if ($hash !== $user->password) {
            return null;
        }

        return $user;
    }

    /**
     * @param string|int $id
     * @return User|null
     */
    public function findByUid($id)
    {
        return $this->findWhere(['userid' => $id])
            ->first()
            ;
    }

    /**
     * @param string|int $id
     * @return User|null
     */
    public function findByAid($id)
    {
        return $this->findWhere(['adminid' => $id])
            ->first()
            ;
    }
}
