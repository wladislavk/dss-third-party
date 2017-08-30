<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class AbstractGuard implements Guard
{
    /** @var string */
    protected $modelPrimaryKey = 'id';

    /** @var array */
    protected $enforceCredentials = [];

    /** @var AbstractRepository */
    protected $repository;

    /** @var Authenticatable */
    protected $model = null;

    /**
     * @param AbstractRepository $repository
     */
    public function __construct(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return bool
     */
    public function check()
    {
        return is_object($this->user());
    }

    /**
     * @return bool
     */
    public function guest()
    {
        return is_null($this->user());
    }

    /**
     * @return Authenticatable|null
     */
    public function user()
    {
        return $this->model;
    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function once(array $credentials = [])
    {
        $this->model = $this->modelByCredentials($credentials);
        return $this->user();
    }

    /**
     * @param array $credentials
     * @param bool $remember
     * @param bool $login
     * @return Authenticatable|null
     */
    public function attempt(array $credentials = [], $remember = false, $login = true)
    {
        return $this->once($credentials);
    }

    /**
     * @param string $field
     * @return null
     */
    public function basic($field = 'email')
    {
        return null;
    }

    /**
     * @param string $field
     * @return null
     */
    public function onceBasic($field = 'email')
    {
        return null;
    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function validate(array $credentials = [])
    {
        $model = $this->modelByCredentials($credentials);
        return $model;
    }

    /**
     * @param Authenticatable $model
     * @param bool $remember
     * @return void
     */
    public function login(Authenticatable $model, $remember = false)
    {
        $this->model = $model;
    }

    /**
     * @param int|string $id
     * @param bool $remember
     * @return Authenticatable|null
     */
    public function loginUsingId($id, $remember = false)
    {
        $this->model = $this->modelByCredentials([
            $this->modelPrimaryKey => $id
        ]);
        return $this->user();
    }

    /**
     * @return bool
     */
    public function viaRemember()
    {
        return false;
    }

    /**
     * @return void
     */
    public function logout()
    {

    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    protected function modelByCredentials(array $credentials)
    {
        $credentials = array_merge($credentials, $this->enforceCredentials);

        $model = $this->repository
            ->findWhere($credentials)
            ->first()
        ;

        return $model;
    }

    /**
     * @param string|int $id
     * @return Authenticatable
     * @throws ModelNotFoundException
     */
    protected function modelById($id)
    {
        $model = $this->repository
            ->find($id)
        ;

        return $model;
    }
}
