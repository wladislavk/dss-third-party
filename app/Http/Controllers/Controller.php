<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Dental\User;

abstract class Controller extends BaseRestController
{
    use DispatchesJobs, ValidatesRequests;

    protected $currentUser;
    protected $auth;

    public function __construct(
        Repository $resources,
        Request $request,
        JWTAuth $auth,
        User $userModel
    ) {
        parent::__construct($resources, $request);
        // TODO: see how it is possible to generate JWT token while testing
        if (env('APP_ENV') != 'testing') {
            $this->currentUser = $this->getUserInfo($auth, $userModel);
            $this->auth        = $auth;
        }
    }

    /**
     * @param JWTAuth $auth
     * @param User $userModel
     * @return mixed
     */
    private function getUserInfo(JWTAuth $auth, User $userModel)
    {
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

        if ($docId) {
            $user->docid = $docId;
        } else {
            $user->docid = $user->userid;
        }

        $user->user_type = $userModel->getUserType($user->docid)->user_type ?: 0;

        return $user;
    }
}
