<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use DentalSleepSolutions\Auth\Legacy;

class UserRepository extends AbstractRepository
{
    /** @var Legacy */
    private $legacyAuth;

    public function __construct(
        Application $app,
        Legacy $legacyAuth
    )
    {
        parent::__construct($app);
        $this->legacyAuth = $legacyAuth;
    }

    public function model()
    {
        return User::class;
    }

    /**
     * @param int|string $id
     * @return User|null
     */
    public function findByIdOrEmail($id)
    {
        if (!strlen((string)$id)) {
            return null;
        }

        $ids = [];
        $compositeId = $this->legacyAuth->decomposeId($id);

        if (strlen($compositeId->adminId)) {
            $ids[] = $compositeId->adminId;
        }

        if (strlen($compositeId->userId)) {
            $ids[] = $compositeId->userId;
        }

        return $this->model->where(function (Builder $q) use ($id, $ids) {
            $q->where('email', $id);

            if (count($ids)) {
                $q->orWhereIn('id', $ids);
            }
        })
            ->orderBy('id', 'ASC')
            ->get()
            ;
    }

    public function findByIdOrField($field, $value = null, $columns = ['*'])
    {
        if (is_string($value) && $this->legacyAuth->isValidCompositeId($value)) {
            $ids = [];

            $compositeId = $this->legacyAuth->decomposeId($value);

            if (strlen($compositeId->adminId)) {
                $ids[] = $compositeId->adminId;
            }

            if (strlen($compositeId->userId)) {
                $ids[] = $compositeId->userId;
            }

            if (count($ids)) {
                $value = $ids;
            }
        }

        if (is_array($value)) {
            return $this->findWhereIn($field, $value, $columns);
        }

        return $this->findWhere([$field => $value], $columns);
    }
}
