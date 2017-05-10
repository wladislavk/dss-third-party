<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Dental\User;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $currentAdmin;
    protected $currentUser;
    protected $auth;

    public function __construct(JWTAuth $auth, User $userModel)
    {
        /**
         * @ToDo: generate tokens with $auth->fromUser($userModel)
         */
        $this->auth = $auth;
        $userInfo = $this->getUserInfo($auth, $userModel);

        $this->currentAdmin = $userInfo['admin'];
        $this->currentUser = $userInfo['user'];
    }

    private function getUserInfo(JWTAuth $auth, User $userModel)
    {
        $token = $auth->getToken();

        if (!$token) {
            return false;
        }

        $userData = $auth->toUser();

        if (!is_array($userData)) {
            $userData = [
                'admin' => strpos($userData->id, 'a_') === 0 ? $userData : false,
                'user' => strpos($userData->id, 'u_') === 0 ? $userData : false,
            ];
        } else {
            $tmpUserData = [
                'admin' => false,
                'user' => false
            ];

            foreach ($userData as $each) {
                $isAdmin = strpos($each->id, 'a_') === 0;
                $each->id = preg_replace('/\D+/', '', $each->id);

                if ($isAdmin) {
                    $tmpUserData['admin'] = $each;
                } else {
                    $tmpUserData['user'] = $each;
                }
            }

            $userData = $tmpUserData;
        }

        if ($userData['user']) {
            $userData['user']->docid = $userModel->getDocId($userData['user']->id)->docid;
            $userData['user']->user_type = $userModel->getUserType($userData['user']->docid)->user_type ?: 0;
        }

        return $userData;
    }
}
