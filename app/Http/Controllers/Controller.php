<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Helpers\AuthTokenParser;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Logged-in admin
     *
     * @var \DentalSleepSolutions\Eloquent\User|bool
     */
    protected $currentAdmin;

    /**
     * Logged-in user
     *
     * @var \DentalSleepSolutions\Eloquent\User|bool
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
     * @param AuthTokenParser $authToken
     */
    public function __construct(JWTAuth $auth, AuthTokenParser $authToken)
    {
        /**
         * @ToDo: generate tokens with $auth->fromUser($userModel)
         */
        $this->auth = $auth;
        $this->currentAdmin = $authToken->getAdminData();
        $this->currentUser = $authToken->getUserData();
    }
}
