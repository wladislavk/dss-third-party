<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Config\Repository as Config;
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
     * @var Config
     */
    protected $config;

    /**
     * Controller constructor
     *
     * @param JWTAuth $auth
     * @param Config  $config
     * @param AuthTokenParser $authToken
     */
    public function __construct(JWTAuth $auth, Config $config, AuthTokenParser $authToken)
    {
        /**
         * @ToDo: generate tokens with $auth->fromUser($userModel)
         */
        $this->auth = $auth;
        $this->config = $config;
        $this->currentAdmin = $authToken->getAdminData();
        $this->currentUser = $authToken->getUserData();
    }
}
