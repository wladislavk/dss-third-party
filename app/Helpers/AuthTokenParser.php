<?php

namespace DentalSleepSolutions\Helpers;

use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;

class AuthTokenParser
{
    /** @var JWTAuth */
    private $auth;

    /** @var UserRepository */
    private $userRepository;

    /**
     * @param JWTAuth        $auth
     * @param UserRepository $userRepository
     */
    public function __construct(
        JWTAuth $auth,
        UserRepository $userRepository
    )
    {
        $this->auth = $auth;
        $this->userRepository = $userRepository;
    }

    /**
     * @return User|null
     */
    public function getAdminData()
    {
        if (!$this->auth->getToken()) {
            return null;
        }

        $collection = $this->auth->toUser();

        if (!$collection->count()) {
            return null;
        }

        $collection = $collection->all();

        foreach ($collection as $model) {
            if ($this->userRepository->isAid($model->id)) {
                return $model;
            }
        }

        return null;
    }

    /**
     * @return User|null
     */
    public function getUserData()
    {
        if (!$this->auth->getToken()) {
            return null;
        }

        $collection = $this->auth->toUser();

        if (!$collection->count()) {
            return null;
        }

        $collection = $collection->all();

        foreach ($collection as $model) {
            if ($this->userRepository->isUid($model->id)) {
                return $model;
            }
        }

        return null;
    }
}
