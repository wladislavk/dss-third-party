<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;

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
     * @return Authenticatable|null
     */
    public function validate(array $credentials = [])
    {
        $model = $this->modelByCredentials($credentials);
        return $model;
    }

    /**
     * @param Authenticatable $model
     * @return void
     */
    public function login(Authenticatable $model)
    {
        $this->model = $model;
    }

    public function setUser(Authenticatable $user)
    {
        return $this->user();
    }

    public function id()
    {
        return $this->user()->getAuthIdentifier();
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
}
