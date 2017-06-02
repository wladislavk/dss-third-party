<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Dental\User as UserModel;
use DentalSleepSolutions\Eloquent\User;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Logged-in admin
     *
     * @var User|bool
     */
    protected $currentAdmin;

    /**
     * Logged-in user
     *
     * @var User|bool
     */
    protected $currentUser;

    /**
     * @var JWTAuth
     */
    protected $auth;

    /**
     * Controller constructor
     *
     * @param JWTAuth $auth
     * @param UserModel $userModel
     */
    public function __construct(JWTAuth $auth, UserModel $userModel)
    {
        /**
         * @ToDo: generate tokens with $auth->fromUser($userModel)
         */
        $this->auth = $auth;
        $loginInfo = $this->getLoginInfo($auth, $userModel);

        $this->currentAdmin = Arr::get($loginInfo, 'admin');
        $this->currentUser = Arr::get($loginInfo, 'user');
    }

    /**
     * Extract admin and user from JWT token
     *
     * @param JWTAuth $auth
     * @param UserModel $userModel
     * @return array
     */
    private function getLoginInfo(JWTAuth $auth, UserModel $userModel)
    {
        if (!$auth->getToken()) {
            return [];
        }

        /**
         * User model can return two user instances, for "Login as" functionality: admin + user
         */
        $userModelData = $auth->toUser();

        if (is_array($userModelData)) {
            $loginData = [
                'admin' => $this->getAdminFromModelArray($userModelData),
                'user' => $this->getUserFromModelarray($userModelData, $userModel),
            ];

            return $loginData;
        }

        $loginData = [
            'admin' => $this->getAdminFromModelData($userModelData),
            'user' => $this->getUserFromModelData($userModelData, $userModel),
        ];

        return $loginData;
    }

    /**
     * Return first Admin instance from model array
     *
     * @param array $modelArray
     * @return bool|User
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
     * @param UserModel $userModel
     * @return bool|User
     */
    private function getUserFromModelArray (Array $modelArray, UserModel $userModel)
    {
        $modelData = array_reduce($modelArray, function ($previousData, $currentData) use ($userModel) {
            if ($previousData) {
                return $previousData;
            }

            $userData = $this->getUserFromModelData($currentData, $userModel);
            return $userData;
        }, false);

        return $modelData;
    }

    /**
     * Return User data if it belongs to an Admin
     *
     * @param User $modelData
     * @return bool|User
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
     * @param UserModel $userModel
     * @return bool|User
     */
    private function getUserFromModelData (User $modelData, UserModel $userModel)
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
        $modelData->user_type = 0;
        $modelData->docid = $userModel->getDocId($modelData->id)->docid;

        $userType = $userModel->getUserType($modelData->docid)->user_type;

        if ($userType) {
            $modelData->user_type = $userType;
        }

        return $modelData;
    }
}
