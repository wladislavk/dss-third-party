<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Database\Eloquent\Collection;
use DentalSleepSolutions\Helpers\SudoHelper;
use Illuminate\Container\Container as Application;

class UserRepository extends AbstractRepository
{
    /** @var SudoHelper */
    private $sudo;

    public function __construct(
        Application $app,
        SudoHelper $sudo
    )
    {
        parent::__construct($app);
        $this->sudo = $sudo;
    }

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
     * @return Collection
     */
    public function findById($id, $columns = ['*'])
    {
        $sudoId = $this->sudo->parseId($id);
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
     * @return Collection|User|null
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        if ($field === 'id') {
            return self::findById($value, $columns);
        }

        return parent::findByField($field, $value, $columns);
    }

    /**
     * @param array $where
     * @return User|null
     */
    public function findByCredentials(array $where)
    {
        return $this->findWhere($where)
            ->first()
            ;
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

    /**
     * @param string|int $adminId
     * @param string|int $userId
     * @return string
     */
    public function sudoId($adminId, $userId)
    {
        /** @todo Refactor this method & call, it breaks the SRP */
        return $this->sudo->sudoId($adminId, $userId);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function isUid($id)
    {
        /** @todo Refactor this method & call, it breaks the SRP */
        return $this->sudo->isUid($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function isAid($id)
    {
        /** @todo Refactor this method & call, it breaks the SRP */
        return $this->sudo->isAid($id);
    }
}
