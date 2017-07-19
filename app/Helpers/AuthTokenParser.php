<?php

namespace DentalSleepSolutions\Helpers;

use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\User;

class AuthTokenParser
{
    /** @var JWTAuth */
    private $auth;

    /**
     * @param JWTAuth $auth
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Extract "Admin" user from JWT token
     *
     * @return User
     */
    public function getAdminData()
    {
        return $this->getAgnosticData([$this, 'getAdminFromModelArray'], [$this, 'getAdminFromModelData']);
    }

    /**
     * Extract "User" user from JWT token
     *
     * @return User
     */
    public function getUserData()
    {
        return $this->getAgnosticData([$this, 'getUserFromModelArray'], [$this, 'getUserFromModelData']);
    }

    /**
     * Model data extraction
     *
     * @param callable $getDataFromModelArray
     * @param callable $getDataFromModelData
     * @return User
     */
    private function getAgnosticData (callable $getDataFromModelArray, callable $getDataFromModelData) {
        if (!$this->auth->getToken()) {
            return null;
        }

        /**
         * User model can return two user instances, for "Login as" functionality: admin + user
         */
        $userModelData = $this->auth->toUser();

        if (is_array($userModelData)) {
            return $getDataFromModelArray($userModelData);
        }

        return $getDataFromModelData($userModelData);
    }

    /**
     * Return first Admin instance from model array
     *
     * @param array $modelArray
     * @return User
     */
    private function getAdminFromModelArray (Array $modelArray)
    {
        return $this->getAgnosticDataFromModelArray($modelArray, [$this, 'reduceAdminFromModelArray']);
    }

    /**
     * Return first User instance from model array
     *
     * @param array $modelArray
     * @return User
     */
    private function getUserFromModelArray (Array $modelArray)
    {
        return $this->getAgnosticDataFromModelArray($modelArray, [$this, 'reduceUserFromModelArray']);
    }

    /**
     * Reduce model array to first model data match
     *
     * @param array    $modelArray
     * @param callable $reduceDataFromModelArray
     * @return mixed
     */
    private function getAgnosticDataFromModelArray (Array $modelArray, callable $reduceDataFromModelArray) {
        $modelData = array_reduce($modelArray, $reduceDataFromModelArray, null);
        return $modelData;
    }

    /**
     * Auxiliary method to return first Admin instance from model array
     *
     * @param User|bool $previousData
     * @param User|bool$currentData
     * @return User
     */
    private function reduceAdminFromModelArray ($previousData, $currentData) {
        if ($previousData) {
            return $previousData;
        }

        $userData = $this->getAdminFromModelData($currentData);
        return $userData;
    }

    /**
     * Auxiliary method to return first User instance from model array
     *
     * @param User|bool $previousData
     * @param User|bool$currentData
     * @return User
     */
    private function reduceUserFromModelArray ($previousData, $currentData) {
        if ($previousData) {
            return $previousData;
        }

        $userData = $this->getUserFromModelData($currentData);
        return $userData;
    }

    /**
     * Return User data if it belongs to an Admin
     *
     * @param User $modelData
     * @return User
     */
    private function getAdminFromModelData (User $modelData)
    {
        return $this->getAgnosticDataFromModelData($modelData, 'a');
    }

    /**
     * Return User data if it belongs to a User
     *
     * @param User $modelData
     * @return User
     */
    private function getUserFromModelData (User $modelData)
    {
        return $this->getAgnosticDataFromModelData($modelData, 'u');
    }

    /**
     * Return model data if it belongs to the model type
     *
     * @param User   $modelData
     * @param string $modelTypeFlag
     * @return User
     */
    private function getAgnosticDataFromModelData (User $modelData, $modelTypeFlag) {
        $modelTypeFlag = preg_quote($modelTypeFlag);

        /**
         * IDs come from v_users view, that follows the convention:
         *
         * * a_\d: Admin
         * * u_\d: User
         */
        if (!preg_match("/^{$modelTypeFlag}_(?P<id>\d+)$/", $modelData->id, $match)) {
            return null;
        }

        $modelData->id = $match['id'];
        return $modelData;
    }
}
