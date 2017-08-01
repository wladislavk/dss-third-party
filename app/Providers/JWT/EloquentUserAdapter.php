<?php
namespace DentalSleepSolutions\Providers\JWT;

use DentalSleepSolutions\StaticClasses\SudoHelper;
use Tymon\JWTAuth\Providers\User\UserInterface;
use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\Models\User;

class EloquentUserAdapter implements UserInterface
{
    /** @var User */
    private $model;

    /**
     * Create a new User instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the user by the given key, value.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return Model|Model[]
     */
    public function getBy($key, $value)
    {
        /** @todo Method implemented in repository, find a way to inject the dependency */
        if ($key !== 'id' || !SudoHelper::isSudoId($value)) {
            $this->model->where($key, $value);
        }

        $sudoId = SudoHelper::parseId($value);
        $values = [
            $sudoId->id,
            $sudoId->adminId,
            $sudoId->userId,
        ];

        return $this->model->whereIn($key, $values)
            ->orderBy('id', 'ASC')
            ->get()
            ->all()
        ;
    }
}
