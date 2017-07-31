<?php
namespace DentalSleepSolutions\Providers\JWT;

use Tymon\JWTAuth\Providers\User\UserInterface;
use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository as Repository;

class EloquentUserAdapter implements UserInterface
{
    /** @var Repository */
    private $repository;

    /**
     * Create a new User instance.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the user by the given key, value.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return Model
     */
    public function getBy($key, $value)
    {
        return $this->repository
            ->findByIdOrField($key, $value)
            ->all()
        ;
    }
}
