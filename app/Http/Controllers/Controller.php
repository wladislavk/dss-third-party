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

    protected $currentUser;
    protected $auth;

    public function __construct(JWTAuth $auth, User $userModel)
    {
        // TODO: see how it is possible to generate JWT token while testing
        if (env('APP_ENV') != 'testing') {
            $this->currentUser = $this->getUserInfo($auth, $userModel);
            $this->auth        = $auth;
        }
    }

    private function getUserInfo(JWTAuth $auth, User $userModel)
    {
        $user = $auth->toUser();

        $user->id = preg_replace('/(?:u_|a_)/', '', $user->id);

        $docId = $userModel->getDocId($user->id)->docid;

        if ($docId) {
            $user->docid = $docId;
        } else {
            $user->docid = $user->userid;
        }

        $user->user_type = $userModel->getUserType($user->docid)->user_type ?: 0;

        return $user;
    }
}
