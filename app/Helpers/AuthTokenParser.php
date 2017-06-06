<?php

namespace DentalSleepSolutions\Helpers;

use function array_reduce;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Dental\User as UserModel;
use DentalSleepSolutions\Eloquent\User;

class AuthTokenParser
{
    /**
     * @var JWTAuth
     */
    protected $auth;

    /**
     * @var UserModel
     */
    protected $model;

    /**
     * Controller constructor
     *
     * @param JWTAuth $auth
     * @param UserModel $model
     */
    public function __construct(JWTAuth $auth, UserModel $model)
    {
        $this->auth = $auth;
        $this->model = $model;
    }

    /**
     * Extract "Admin" user from JWT token
     *
     * @return User|bool
     */
    public function getAdminData()
    {
        if (!$this->auth->getToken()) {
            return false;
        }

        /**
         * User model can return two user instances, for "Login as" functionality: admin + user
         */
        $userModelData = $this->auth->toUser();

        if (is_array($userModelData)) {
            return $this->getAdminFromModelArray($userModelData);
        }

        return $this->getAdminFromModelData($userModelData);
    }

    /**
     * Extract "User" user from JWT token
     *
     * @return User|bool
     */
    public function getUserData()
    {
        if (!$this->auth->getToken()) {
            return false;
        }

        /**
         * User model can return two user instances, for "Login as" functionality: admin + user
         */
        $userModelData = $this->auth->toUser();

        if (is_array($userModelData)) {
            return $this->getUserFromModelArray($userModelData);
        }

        return $this->getUserFromModelData($userModelData);
    }

    /**
     * Return first Admin instance from model array
     *
     * @param array $modelArray
     * @return User|bool
     */
    private function getAdminFromModelArray (Array $modelArray)
    {
        $modelData = array_reduce($modelArray, function ($previousData, $currentData) {
            if ($previousData) {
                return $previousData;
            }

            $adminData = $this->getAdminFromModelData($currentData);
            return $adminData;
        }, false);

        return $modelData;
    }

    /**
     * Return first User instance from model array
     *
     * @param array $modelArray
     * @return User|bool
     */
    private function getUserFromModelArray (Array $modelArray)
    {
        $modelData = array_reduce($modelArray, function ($previousData, $currentData) {
            if ($previousData) {
                return $previousData;
            }

            $userData = $this->getUserFromModelData($currentData);
            return $userData;
        }, false);

        return $modelData;
    }

    /**
     * Return User data if it belongs to an Admin
     *
     * @param User $modelData
     * @return User|bool
     */
    private function getAdminFromModelData (User $modelData)
    {
        /**
         * IDs come from v_users view, that follows the convention:
         *
         * * a_\d: Admin
         * * u_\d: User
         */
        if (!preg_match('/^a_(?P<id>\d+)$/', $modelData->id, $match)) {
            return false;
        }

        $modelData->id = $match['id'];
        return $modelData;
    }

    /**
     * Return User data if it belongs to a User
     *
     * @param User $modelData
     * @return User|bool
     */
    private function getUserFromModelData (User $modelData)
    {
        /**
         * IDs come from v_users view, that follows the convention:
         *
         * * a_\d: Admin
         * * u_\d: User
         */
        if (!preg_match('/^u_(?P<id>\d+)$/', $modelData->id, $match)) {
            return false;
        }

        $modelData->id = $match['id'];
        return $modelData;
    }
}
