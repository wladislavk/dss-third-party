<?php
namespace DentalSleepSolutions\Providers\JWT;

use Tymon\JWTAuth\Providers\User\UserInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentUserAdapter implements UserInterface
{
    /**
     * @var Model
     */
    protected $user;

    /**
     * Create a new User instance.
     *
     * @param  Model $user
     */
    public function __construct(Model $user)
    {
        $this->user = $user;
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
        $value = explode('|', $value);
        return $this->user->whereIn($key, $value)
            ->orderBy('id', 'ASC')
            ->get()
            ->all()
        ;
    }
}
