<?php
namespace DentalSleepSolutions\Providers\JWT;

use Tymon\JWTAuth\Providers\User\UserInterface;
use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Facades\UserRepositoryFacade;

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
        return UserRepositoryFacade::findByField($key, $value);
    }
}
