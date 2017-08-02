<?php

namespace DentalSleepSolutions\Helpers;

use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\StaticClasses\SudoHelper;
use Illuminate\Database\Eloquent\Collection;

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
     * @return User|null
     */
    public function getAdminData()
    {
        return $this->getAgnosticData([$this, 'getAdminFromModelArray'], [$this, 'getAdminFromModelData']);
    }

    /**
     * Extract "User" user from JWT token
     *
     * @return User|null
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
     * @return User|null
     */
    private function getAgnosticData (callable $getDataFromModelArray, callable $getDataFromModelData) {
        if (!$this->auth->getToken()) {
            return null;
        }

        /**
         * User model can return two user instances, for "Login as" functionality: admin + user
         */
        $userModelData = $this->auth->toUser();

        if ($userModelData instanceof Collection || is_subclass_of($userModelData, Collection::class)) {
            $userModelData = $userModelData->all();
        }

        if (is_array($userModelData)) {
            return $getDataFromModelArray($userModelData);
        }

        return $getDataFromModelData($userModelData);
    }

    /**
     * Return first Admin instance from model array
     *
     * @param array $modelArray
     * @return User|null
     */
    private function getAdminFromModelArray (array $modelArray)
    {
        return $this->getAgnosticDataFromModelArray($modelArray, [$this, 'reduceAdminFromModelArray']);
    }

    /**
     * Return first User instance from model array
     *
     * @param array $modelArray
     * @return User|null
     */
    private function getUserFromModelArray (array $modelArray)
    {
        return $this->getAgnosticDataFromModelArray($modelArray, [$this, 'reduceUserFromModelArray']);
    }

    /**
     * Reduce model array to first model data match
     *
     * @param array    $modelArray
     * @param callable $reduceDataFromModelArray
     * @return User|null
     */
    private function getAgnosticDataFromModelArray (array $modelArray, callable $reduceDataFromModelArray) {
        $modelData = array_reduce($modelArray, $reduceDataFromModelArray, null);
        return $modelData;
    }

    /**
     * Auxiliary method to return first Admin instance from model array
     *
     * @param User|null $previousData
     * @param User|null $currentData
     * @return User|null
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
     * @param User|null $previousData
     * @param User|null $currentData
     * @return User|null
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
     * @return User|null
     */
    private function getAdminFromModelData (User $modelData)
    {
        return $this->getAgnosticDataFromModelData($modelData, SudoHelper::ADMIN_PREFIX);
    }

    /**
     * Return User data if it belongs to a User
     *
     * @param User $modelData
     * @return User|null
     */
    private function getUserFromModelData (User $modelData)
    {
        return $this->getAgnosticDataFromModelData($modelData, SudoHelper::USER_PREFIX);
    }

    /**
     * Return model data if it belongs to the model type
     *
     * @param User   $modelData
     * @param string $modelTypeFlag
     * @return User|null
     */
    private function getAgnosticDataFromModelData (User $modelData, $modelTypeFlag) {
        $modelTypeFlag = preg_quote($modelTypeFlag);

        if (!preg_match("/^{$modelTypeFlag}(?P<id>\d+)$/", $modelData->id, $match)) {
            return null;
        }

        $modelData->id = $match['id'];
        return $modelData;
    }
}
