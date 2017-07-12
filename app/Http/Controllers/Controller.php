<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Dental\User;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    // TODO: this class should include common REST methods for all its children

    use DispatchesJobs, ValidatesRequests;

    /** @var User|mixed */
    protected $currentUser;

    protected $auth;

    public function __construct(
        JWTAuth $auth,
        User $userModel
    ) {
        // TODO: see how it is possible to generate JWT token while testing
        if (env('APP_ENV') != 'testing') {
            $this->currentUser = $this->getUserInfo($auth, $userModel);
            $this->auth        = $auth;
            return;
        }
        $this->currentUser = new User();
    }

    /**
     * @param JWTAuth $auth
     * @param User $userModel
     * @return mixed
     */
    private function getUserInfo(JWTAuth $auth, User $userModel)
    {
        /** @var User $user */
        $user = $auth->toUser();

        if (!$user) {
            return $user;
        }

        $user->id = preg_replace('/(?:u_|a_)/', '', $user->id);

        /**
         * @ToDo: Handle admin tokens
         * @see AWS-19-Request-Token
         */
        $getter = $userModel->getDocId($user->id);

        if (!$getter) {
            return $user;
        }

        $docId = $getter->docid;

        $user->docid = $user->userid;
        if ($docId) {
            $user->docid = $docId;
        }

        $user->user_type = 0;
        $userType = $userModel->getUserType($user->docid);
        if ($userType) {
            $user->user_type = $userType->user_type;
        }

        return $user;
    }
}
